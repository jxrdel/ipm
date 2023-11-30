<?php

namespace App\Models;

use GuzzleHttp\Psr7\Header;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesHeader extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'RoleNavMenuHeaders';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'ID',
        'RoleId',
        'HeaderId',
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'RoleId', 'RoleId');
    }

    public function header()
    {
        return $this->belongsTo(Headers::class, 'HeaderId', 'RoleId');
    }
}
