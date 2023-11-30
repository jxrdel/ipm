<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'RoleAlloweds';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'UserId',
        'RoleId',
        'IsPrimary',
    ];
}
