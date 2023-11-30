<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermissions extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'PermissionAlloweds';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'UserId',
        'PermissionId',
    ];
}
