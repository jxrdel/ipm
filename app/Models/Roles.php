<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'Roles';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'Name',
        'Description',
        'Avatar',
    ];

    public function users()
    {
        return $this->belongsToMany(Users::class, 'RoleAlloweds', 'RoleId', 'UserId');
    }

    public function headers()
    {
        return $this->belongsToMany(Headers::class, 'RoleNavMenuHeaders', 'RoleId', 'HeaderId');
    }

    public function permissiongroups()
    {
        return $this->belongsToMany(PGroup::class, 'RolePermissionGroups', 'RoleId', 'PermissionGroupId');
    }
    
    public function hasPermission($permissionName)
    {
        return $this->permissiongroups->flatMap->permissions->pluck('Description')->contains($permissionName);
    }
}
