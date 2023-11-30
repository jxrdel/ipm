<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'BusinessGroups';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'IsActive',
        'Name',
        'Abbreviation',
        'Details',
        'BusinessGroupTypeId',
        'ParentId',
    ];

    public function department()
    {
        return $this->hasMany(InternalContacts::class, 'DepartmentID', 'ID');
    }
}
