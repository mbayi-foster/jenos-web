<?php
use App\Http\Controllers\Api\AuthClientController;
use App\Http\Controllers\Api\Clients\AuthClientController as ClientsAuthController;
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

Route::post('/clients/new-user', [ClientsAuthController::class, 'registreEmail']);
Route::post('/clients', [ClientsAuthController::class, 'storeClient']);
Route::post('/clients/login', [ClientsAuthController::class, 'login']);
Route::post('/clients/forget-password', [ClientsAuthController::class,'verifyEmail']);
Route::get('/clients/{id}', [ClientsAuthController::class, 'getUser']);
Route::post('/clients/change-forget-password', [ClientsAuthController::class,'changeForgetPassword']);
Route::post('/clients/change-password', [ClientsAuthController::class,'changePassword']);
// Route::apiResource("paniers", PanierController::class);
// Route::apiResource("map", MapController::class);
// Route::apiResource("commandes", CommandeController::class);
// Route::get("mobile-home", [MobileHomeController::class, "home"]);
// //Route::get("mobile-menu", [MobileHomeController::class, "menu"]);
// Route::get("mobile-plats-menu/{id}", [MobileHomeController::class, "plats_by_menu"]);
// Route::get("mobile-plat/{id}", [MobileDetailsController::class, "plat"]);
// Route::apiResource("mobile-menu", MenuMobileController::class);
// Route::get("search/{mot}", [PlatController::class, "search"]);
// Route::get("search/", [PlatController::class, "all"]);
