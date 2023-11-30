<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternalContacts extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'InternalContacts';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'IsActive',
        'FirstName',
        'LastName',
        'Email',
        'PhoneExt',
        'BusinessGroupId',
        'MOHRoleId',
    ];

    public function department()
    {
        return $this->belongsTo(Departments::class, 'DepartmentID', 'ID');
    }
}
