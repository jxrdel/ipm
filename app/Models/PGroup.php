<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PGroup extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'PermissionGroups';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'Name',
        'Description',
    ];

    public function users()
    {
        return $this->belongsToMany(Users::class, 'PermissionGroupAlloweds', 'PermissionGroupId', 'UserId');
    }
}
