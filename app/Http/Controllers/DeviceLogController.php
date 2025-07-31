<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\FirebaseService;

use Illuminate\Http\Request;

class DeviceLogController extends Controller
{
    public function index(Request $request)
    {
        $devices = Device::all();
        $device = null;
        $flowData = null;
        $history = null;
        // dd('devices', $devices);

        $deviceId = $request->input('device_id');
        if ($deviceId) {
            $device = Device::find($deviceId);

            if ($device) {
                $firebase = new FirebaseService($device->firebase_url, $device->secret);
                $flowData = $firebase->get('flowSensor');
                $history = $firebase->get('Riwayat');
            } else {
                return redirect()->route('device_log.device-log-dashboard')->with('error', 'Device tidak ditemukan.');
            }
        }

        return view('device_log.device-log-dashboard', compact('devices', 'device', 'flowData', 'history'));
    }

    public function showRiwayat(Request $request)
    {
        $user = Auth::user();
        $device = $user->device;

        if (!$device) {
            return back()->with('error', 'Device tidak ditemukan.');
        }

        $firebase = new FirebaseService($device->firebase_url, $device->secret);
        $historyRaw = $firebase->get('Riwayat') ?? [];

        return view('dashboard.water-usage', [
            'history' => $historyRaw,
            'selectedMonth' => now()->format('Y-m'),
        ]);
    }
}
