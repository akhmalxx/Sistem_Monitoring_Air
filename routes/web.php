<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DeviceLogController;
use App\Http\Controllers\SensorController;

use App\Services\FirebaseService;

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

Route::get('/sensor', [SensorController::class, 'index']);

Route::get('/debug/firebase', function () {
    $firebase = new FirebaseService(); // pakai default .env

    $flow = $firebase->get('flowSensor/flowRate');
    $total = $firebase->get('flowSensor/totalML');
    $riwayat = $firebase->get('Riwayat'); // <--- ubah path di sini

    // Optional: urutkan berdasarkan tanggal terbaru
    if (is_array($riwayat)) {
        krsort($riwayat);
    }

    return response()->json([
        'flowRate' => $flow,
        'totalML' => $total,
        'riwayat' => $riwayat,
    ]);
});
Route::get('/api/riwayat-air', function () {
    $firebase = new FirebaseService();
    $riwayat = $firebase->get('Riwayat');

    // sort by tanggal ascending (optional)
    ksort($riwayat);

    return response()->json($riwayat);
});




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

Route::get('/device-log', [DeviceLogController::class, 'index'])->name('device.log');
// });
