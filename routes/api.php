<?php

use App\Http\Controllers\Api\AuthClientController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\MobileHomeController;
use App\Http\Controllers\Api\PlatController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ZoneController;
use Illuminate\Support\Facades\Route;

/* api pour le web de vue js */
Route::apiResource('users', UserController::class);
Route::apiResource('zones', ZoneController::class);
Route::apiResource('plats', PlatController::class);
Route::apiResource('menus', MenuController::class);
Route::apiResource('roles', RoleController::class);
Route::get('status/change/{id}', [UserController::class, 'change_status'])->name('status.users.change');
Route::get('plats/status/true/', [PlatController::class, 'plats_status'])->name('plats.true');
Route::get('zones/status/change/{id}', [ZoneController::class, 'change_status'])->name('status.zones.change');
Route::get('plats/status/change/{id}', [PlatController::class, 'change_status']);
Route::get('menus/status/change/{id}', [MenuController::class, 'change_status']);



Route::post('login/users', [UserController::class,'login']);
Route::post('register',[AuthClientController::class, 'store'])->name('api-register');

Route::get('gerants', [UserController::class,'gerants'])->name('gerants');


// apis pour le mobile

// authentfictions modules 
Route::post('login', [AuthClientController::class, 'login'])->name('api-login');



//modules homes

Route::get("mobile-home", [MobileHomeController::class,"home"]);
Route::get("mobile-menu", [MobileHomeController::class,"menu"]);
