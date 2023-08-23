<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FetchDataController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);


Route::middleware(['auth:sanctum', 'user-role:admin'])->group(function () {
    // User account routes
    Route::get('users/{from?}/{to?}', [FetchDataController::class, 'getusers'])->name('getusers');


    // Bags routes
    Route::get('bags/{from?}/{to?}', [FetchDataController::class, 'getbags'])->name('getbags');


    // Item routes
    Route::get('items/{from?}/{to?}', [FetchDataController::class, 'getitems'])->name('getitems');


    // Trip routes
    Route::get('trips/{from?}/{to?}', [FetchDataController::class, 'gettrips'])->name('gettrips');


    // Trip routes
    Route::get('trip_logs/{from?}/{to?}', [FetchDataController::class, 'gettrip_logs'])->name('gettrip_logs');
});
