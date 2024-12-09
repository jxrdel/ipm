<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'NotificationItems';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'Label',
        'ItemName',
        'Icon',
        'FontColour',
        'ItemController',
        'ItemAction',
        'ItemId',
        'DisplayDate',
        'TypeId',
        'StatusId',
        'StatusDetails',
        'StatusCreatorId',
        'StatusCreationDate',
        'IsCustomNotification',
        'CustomMessage',
    ];

    public function contract()
    {
        if ($this->TypeId == 1){
            return $this->belongsTo(PurchaseContracts::class, 'ItemId', 'ID');
        }
        return $this->belongsTo(EmployeeContracts::class, 'ItemId', 'ID');
    }

    public function internalcontacts()
    {
        return $this->belongsToMany(InternalContacts::class, 'InternalContactNotificationItems', 'NotificationItemId', 'InternalContactId');
    }
}
