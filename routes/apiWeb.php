<?php
use App\Http\Controllers\Api\AuthClientController;
use App\Http\Controllers\Api\CommuneController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\LivreurController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PlatController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ZoneController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CommandeController;


/* api pour le web de vue js */
Route::apiResource('users', UserController::class);
Route::apiResource('communes', CommuneController::class);
Route::apiResource('zones', ZoneController::class);
Route::apiResource('plats', PlatController::class);
Route::apiResource('menus', MenuController::class);
Route::apiResource('roles', RoleController::class);
Route::get('status/change/{id}', [UserController::class, 'change_status'])->name('status.users.change');
Route::get('plats/status/true/', [PlatController::class, 'plats_status'])->name('plats.true');
Route::get('zones/status/change/{id}', [ZoneController::class, 'change_status'])->name('status.zones.change');
Route::get('plats/status/change/{id}', [PlatController::class, 'change_status']);
Route::get('menus/status/change/{id}', [MenuController::class, 'change_status']);



Route::post('login/users', [UserController::class, 'login']);
Route::post('register', [AuthClientController::class, 'store'])->name('api-register');

Route::post('/logout/users', [UserController::class, 'logout']);
Route::get('gerants', [UserController::class, 'gerants'])->name('gerants');

/* tablea de bord */
Route::apiResource("dashboard", DashboardController::class);

/* gerant*/

Route::get("/zones-id/{id}", [ZoneController::class, 'zone_by_id']);
Route::get("/gerants", [ZoneController::class, 'gerants']);

Route::post("/plats-update/{id}", [PlatController::class, "update"]);

// commandes

Route::get("commandes-gerant/{id}", [CommandeController::class, 'commandes_gerant'])->name('commandes.gerant');
Route::get("commandes-gerant/zone/{id}", [CommandeController::class, 'commandes_gerant_by_zone'])->name('commandes.gerant.by.zone');
Route::post("commandes-gerant/valider/{id}", [CommandeController::class, 'valider_commande'])->name('commandes.gerant.valider');

// livreur
Route::get("livreurs-by-zone/{id}", [LivreurController::class, 'livreurs_by_zone'])->name('livreurs.by.zone');