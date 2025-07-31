<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\User;
use App\Services\FirebaseService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $devices = Device::all();

        return view('device.device-dashboard', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $usedUserIds = Device::pluck('user_id')->toArray();
        return view('device.create-device', compact('users', 'usedUserIds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'apikey' => 'required|string|unique:devices',
            'secret' => 'nullable|string',
            'firebase_url' => 'required|url',

        ]);
        // dd($validated);
        Device::create($validated);

        return redirect()->route('device-list.index')->with('success', 'Device created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        $users = User::all();
        return view('device.edit-device', compact('device', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'apikey' => 'required|string|unique:devices,apikey,' . $device->id,
            'secret' => 'nullable|string',
            'firebase_url' => 'required|url',
        ]);

        $device->update($validated);

        return redirect()->route('device-list.index')
            ->with('success', 'Device updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $device = Device::findOrFail($id);
        $device->delete();

        return redirect()->route('device-list.index')->with('success', 'Device deleted successfully.');
    }

    public function selectFirebase()
    {
        $device = Device::find(2);

        if (!$device) {
            return 'Device tidak ditemukan.';
        }

        $firebase = new FirebaseService($device->firebase_url, $device->secret);

        $flowData = $firebase->get('flowSensor');
        $history = $firebase->get('Riwayat');

        dd([
            'flowData' => $flowData,
            'history' => $history,
        ]);
    }
}
