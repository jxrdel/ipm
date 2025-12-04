<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveUpload extends Model
{
    use HasFactory;

    protected $table = 'leave_uploads';

    protected $fillable = [
        'leave_id',
        'file_path',
        'original_name',
    ];

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }
}