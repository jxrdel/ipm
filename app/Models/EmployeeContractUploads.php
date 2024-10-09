<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeContractUploads extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID';

    protected $table = 'EmployeeContractUploads';

    public  $timestamps = false;

    protected $fillable = [
        'ID',
        'EmployeeContractID',
        'FilePath',
        'UploadedBy',
        'UploadedDate',
    ];
}
