<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceLogController;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/login');
Route::get('/login', function () {
    return view('auth.auth-login',);
});
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::middleware(['auth', 'role.prefix'])->prefix('superadmin')->group(function () {
Route::get('/dashboard', function () {
    return view('dashboard.dashboard', ['type_menu' => 'dashboard']);
});
Route::get('/water-usage', function () {
    return view('dashboard.water-usage', ['type_menu' => 'dashboard']);
});
Route::get('/admin-dashboard', function () {
    return view('admin-dashboard.admin-dashboard', ['type_menu' => 'dashboard']);
});

Route::resource('user-management', UserController::class);
Route::resource('device-list', DeviceController::class);

Route::get('/device-log', function () {
    return view('device_log.device-log-dashboard');
});
// });
