<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Device;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalAdmin = User::where('role', 'Admin')->count();
        $totalUser = User::where('role', 'User')->count();
        $totalDevice = Device::count();

        return view('admin-dashboard.admin-dashboard', compact('totalAdmin', 'totalUser', 'totalDevice'));
    }
}
