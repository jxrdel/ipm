<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionGroups extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'PermissionGroupAlloweds';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'UserId',
        'PermissionGroupId',
    ];
}
