<?php
use App\Http\Controllers\Api\AuthClientController;
use App\Http\Controllers\Api\Clients\AuthClientController as ClientsAuthController;
use App\Http\Controllers\Api\Clients\ClientHomeController;
use App\Http\Controllers\Api\CommandeController;
use App\Http\Controllers\Api\MapController;
use App\Http\Controllers\Api\MenuMobileController;
use App\Http\Controllers\Api\MobileDetailsController;
use App\Http\Controllers\Api\MobileHomeController;
use App\Http\Controllers\Api\PanierController;
use App\Http\Controllers\Api\PlatController;
use Illuminate\Support\Facades\Route;


/** 
 * 
 * Ici toutes les routes commences avec /clients
 * 1. Les routes d'authentifications
 * 2. Les routes de l'acceuil (menus, plats, recherches, profiles, commandes)
 */

 
/// Routes des authentifications
Route::post('/clients/new-user', [ClientsAuthController::class, 'registreEmail']);
Route::post('/clients', [ClientsAuthController::class, 'storeClient']);
Route::post('/clients/login', [ClientsAuthController::class, 'login']);
Route::post('/clients/forget-password', [ClientsAuthController::class,'verifyEmail']);
Route::get('/clients/{id}', [ClientsAuthController::class, 'getUser']);
Route::post('/clients/change-forget-password', [ClientsAuthController::class,'changeForgetPassword']);
Route::post('/clients/change-password', [ClientsAuthController::class,'changePassword']);



/// Routes Homes
Route::get('/clients/home-page', [ClientHomeController::class,'homePage'])->name('clients.homepage');
