<?php
use App\Http\Controllers\Api\AuthClientController;
use App\Http\Controllers\Api\CommuneController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LivreurController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PlatController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ZoneController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CommandeController;


/* api pour le web de vue js */


Route::prefix('users')->group(function () {

    // gestions des utilisateurs
    Route::apiResource('/', UserController::class);
    Route::get('status/change/{id}', [UserController::class, 'change_status']);
    Route::post('login', [UserController::class, 'login']);
    Route::post('logout', [UserController::class, 'logout']);
    Route::apiResource('roles', RoleController::class);

    // gestion des livreurs
    Route::apiResource('livreurs', LivreurController::class);
    Route::get("zone/livreurs/{id}", [LivreurController::class, 'livreurs_by_zone']);

    // gestion des communes & des zones
    Route::apiResource('communes', CommuneController::class);
    Route::apiResource('zones', ZoneController::class);
    Route::get('zones/status/change/{id}', [ZoneController::class, 'change_status']);
    Route::get('communes/status/change/{id}', [CommuneController::class, 'changeStatus']);
    Route::get("gerants", [ZoneController::class, 'gerants']);

    // gestion des plats & des menus
    Route::apiResource('plats', PlatController::class);
    Route::apiResource('menus', MenuController::class);
    Route::get('plats/status/change/{id}', [PlatController::class, 'change_status']);
    Route::get('menus/status/change/{id}', [MenuController::class, 'change_status']);

    // tableau de board
    Route::apiResource("dashboard", DashboardController::class);
    Route::get('clients', [DashboardController::class, 'clients']);

    // gerants
    Route::get("gerants/zones/{id}", [ZoneController::class, 'gerantZones']);
    Route::get('gerants/zones/livreurs/{id}', [LivreurController::class, 'livreurByZone']);

    // commandes
    Route::get('commandes/{zone}', [CommandeController::class, 'commandes']);
    Route::get('commandes-id/{id}', [CommandeController::class, 'show']);
    Route::get("commandes-gerant/{id}", [CommandeController::class, 'commandes_gerant']);
    Route::get("commandes-gerant/zone/{id}", [CommandeController::class, 'commandes_gerant_by_zone']);
    Route::post("commandes-gerant/valider/{id}", [CommandeController::class, 'valider_commande']);


});