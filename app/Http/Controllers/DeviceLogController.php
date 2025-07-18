<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;

class DeviceLogController extends Controller
{
    public function index()
    {
        $devices = Device::all();
        return view('device_log.device-log-dashboard', compact('devices'));

        // return view('device_log.device-log-dashboard', compact('deviceLogs'));
    }
}
