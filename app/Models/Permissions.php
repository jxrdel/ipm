<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permissions extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'Permissions';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'Controller',
        'Action',
        'Tag',
        'BusinessGroupId',
        'Description',
    ];
}
