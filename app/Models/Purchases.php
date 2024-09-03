<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'ExternalPurchases';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'Name',
        'Details',
        'IsActive',
        'ExternalPurchaseTypeId',
        'ExternalContactCompanyId',
    ];
}
