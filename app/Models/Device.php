<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'apikey',
        'firebase_url',
    ];

    /**
     * Relasi: Satu Device dimiliki oleh satu User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Satu Device memiliki banyak Log
     */
    public function logs()
    {
        return $this->hasMany(DeviceLog::class);
    }
}
