<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Controllers\Roles;
use App\Models\Roles as ModelsRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Users extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;

    protected $table = 'Users';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'Name',
        'Avatar',
        'IsSysAdmin',
        'IsActive',
        'UsrRolePermTimestamp',
        'InternalContactId',
    ];

    public function roles()
    {
        return $this->belongsToMany(ModelsRoles::class, 'RoleAlloweds', 'UserId', 'RoleId');
    }
    
    public function hasRole($role)
    {
        return $this->roles()->where('Name', $role)->exists();
    }

    public function permissiongroups()
    {
        return $this->belongsToMany(PGroup::class, 'PermissionGroupAlloweds', 'UserId', 'PermissionGroupId');
    }
    
    public function hasPermission($permissionName)
    {
        return $this->roles->flatMap->permissiongroups->flatMap->permissions->pluck('Description')->contains($permissionName);
    }

    public function internalcontact(){
        return $this->belongsTo(InternalContacts::class, 'InternalContactId', 'ID');
    }
    
    public function hasHeader($header)
    {
        return $this->roles->flatMap->headers->pluck('Label')->contains($header);
    }
}
