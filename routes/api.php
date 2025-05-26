<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\StationController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\MaintenanceRequestController;

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

// التحقق من حالة المصادقة
Route::get('/auth/check', function () {
    return response()->json([
        'authenticated' => auth()->check(),
        'is_admin' => auth()->check() && auth()->user()->is_admin
    ]);
});

// Public routes
Route::get('/stations', [StationController::class, 'index']);
Route::get('/stations/search', [StationController::class, 'search']);
Route::get('/stations/nearby', [StationController::class, 'nearby']);
Route::get('/stations/{station}', [StationController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Station management
    Route::post('/stations', [StationController::class, 'store']);
    Route::put('/stations/{station}', [StationController::class, 'update']);
    Route::delete('/stations/{station}', [StationController::class, 'destroy']);

    // Booking management
    Route::get('/bookings', [BookingController::class, 'index']);
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);
    Route::put('/bookings/{booking}', [BookingController::class, 'update']);
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);
    Route::get('/stations/{station}/available-slots', [BookingController::class, 'getAvailableSlots']);

    // Maintenance request management
    Route::get('/maintenance-requests', [MaintenanceRequestController::class, 'index']);
    Route::post('/maintenance-requests', [MaintenanceRequestController::class, 'store']);
    Route::get('/maintenance-requests/{maintenanceRequest}', [MaintenanceRequestController::class, 'show']);
    Route::put('/maintenance-requests/{maintenanceRequest}', [MaintenanceRequestController::class, 'update']);
    Route::post('/maintenance-requests/{maintenanceRequest}/cancel', [MaintenanceRequestController::class, 'cancel']);
    Route::get('/stations/{station}/maintenance-history', [MaintenanceRequestController::class, 'getStationHistory']);
});
