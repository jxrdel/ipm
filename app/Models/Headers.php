<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Headers extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'NavMenuHeaders';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'Label',
    ];
}
