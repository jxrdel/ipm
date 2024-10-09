<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeContracts extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'EmployeeContracts';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'Details',
        'FileNumber',
        'FileName',
        'OnlineLocation',
        'IsPerpetual',
        'StartDate',
        'EndDate',
        'EmployeeContactId',
        'CurrentStatusId',
        'MOHRoleId',
        'BusinessGroupId',
        'ManagerContactId',
    ];

    public function internalcontacts()
    {
        return $this->belongsToMany(InternalContacts::class, 'InternalContactEmployeeContracts', 'EmployeeContractId', 'InternalContactId');
    }

    public function notifications()
    {
        return $this->hasMany(Notifications::class, 'ItemId', 'ID')
            ->where('TypeId', 2); // Ensure TypeId is 1 for PurchaseContracts
    }

    public function uploads()
    {
        return $this->hasMany(EmployeeContractUploads::class, 'EmployeeContractID', 'ID');
    }

    public function departments(){
        return $this->belongsToMany(Departments::class, 'EmployeeContractBusinessGroups', 'EmployeeContractId', 'BusinessGroupId');
    }
}
