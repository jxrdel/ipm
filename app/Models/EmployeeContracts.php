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
}
