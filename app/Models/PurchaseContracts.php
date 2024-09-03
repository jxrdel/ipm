<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseContracts extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'PurchaseContracts';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'Name',
        'Details',
        'FileNumber',
        'FileName',
        'OnlineLocation',
        'IsPerpetual',
        'StartDate',
        'EndDate',
        'Cost',
        'CurrentStatusId',
        'ExternalPurchaseId',
        'InternalContactId',
    ];
}
