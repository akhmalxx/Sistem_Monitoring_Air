<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'date',
        'flow_rate',
    ];

    /**
     * Relasi: Log ini milik satu Device
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
