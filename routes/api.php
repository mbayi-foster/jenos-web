<?php

use App\Http\Controllers\Api\AuthClientController;
use App\Http\Controllers\Api\PlatController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ZoneController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::apiResource('zones', ZoneController::class);
Route::apiResource('plats', PlatController::class);
Route::get('status/change/{id}', [UserController::class, 'change_status'])->name('status.users.change');
Route::get('zones/status/change/{id}', [ZoneController::class, 'change_status'])->name('status.zones.change');
Route::get('plats/status/change/{id}', [PlatController::class, 'change_status'])->name('status.zones.change');


Route::post('login', [AuthClientController::class, 'login'])->name('api-login');
Route::post('register',[AuthClientController::class, 'store'])->name('api-register');