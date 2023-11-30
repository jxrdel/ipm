<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MOHRoles extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'MOHRoles';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'Name',
    ];
}
