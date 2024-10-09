<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseContractUploads extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID';

    protected $table = 'PurchaseContractUploads';

    public  $timestamps = false;

    protected $fillable = [
        'ID',
        'PurchaseContractID',
        'FilePath',
        'UploadedBy',
        'UploadedDate',
    ];
}
