<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalPersons extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'ExternalContactPersons';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'IsActive',
        'FirstName',
        'LastName',
        'OtherName',
        'Details',
        'AddressLine1',
        'AddressLine2',
        'Phone1',
        'Phone2',
        'Email',
    ];
}
