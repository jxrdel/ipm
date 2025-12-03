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

    public function purchaseItem()
    {
        return $this->belongsTo(Purchases::class, 'ExternalPurchaseId', 'ID');
    }

    public function internalcontacts()
    {
        return $this->belongsToMany(InternalContacts::class, 'InternalContactPurchaseContracts', 'PurchaseContractId', 'InternalContactId');
    }

    public function notifications()
    {
        return $this->hasMany(Notifications::class, 'ItemId', 'ID')
            ->where('TypeId', 1); // Ensure TypeId is 1 for PurchaseContracts
    }

    public function uploads()
    {
        return $this->hasMany(PurchaseContractUploads::class, 'PurchaseContractID', 'ID');
    }
}
