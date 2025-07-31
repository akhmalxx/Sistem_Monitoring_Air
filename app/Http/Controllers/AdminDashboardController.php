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

        return view('admin-dashboard.admin-dashboard', compact('totalAdmin'));
    }
}
