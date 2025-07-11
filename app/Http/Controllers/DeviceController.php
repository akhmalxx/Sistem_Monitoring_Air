<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
        return view('device.create-device', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'apikey' => 'required|string|unique:devices',
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
        return view('devices.edit', compact('device', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'apikey' => 'required|string|unique:devices,apikey,' . $device->id,
            'firebase_url' => 'required|url',
        ]);

        $device->update($validated);

        return redirect()->route('device-list.index')->with('success', 'Device updated successfully.');
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
}
