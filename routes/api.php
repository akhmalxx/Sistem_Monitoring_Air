<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Services\FirebaseService;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/sensor/data', function () {
    $firebase = new FirebaseService();
    return response()->json([
        'flowRate' => $firebase->get('flowSensor/flowRate'),
        'totalML' => $firebase->get('flowSensor/totalML'),
    ]);
});
