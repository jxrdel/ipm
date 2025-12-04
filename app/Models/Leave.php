<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $table = 'leaves';

    protected $fillable = [
        'leave_type',
        'start_date',
        'end_date',
        'internal_contact_id',
        'days_remaining',
        'days_to_be_taken',
    ];

    public function internalContact()
    {
        return $this->belongsTo(InternalContacts::class, 'internal_contact_id', 'ID');
    }

    public function uploads()
    {
        return $this->hasMany(LeaveUpload::class);
    }
}