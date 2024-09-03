<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalCompanies extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'ExternalContactCompanies';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'IsActive',
        'CompanyName',
        'Details',
        'AddressLine1',
        'AddressLine2',
        'Phone1',
        'Phone2',
        'Email',
    ];
}
