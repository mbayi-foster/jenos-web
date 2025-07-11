<?php

use App\Http\Controllers\Api\Clients\ClientProfileController;
use App\Http\Controllers\Api\Clients\AuthClientController as ClientsAuthController;
use App\Http\Controllers\Api\Clients\ClientCommandeController;
use App\Http\Controllers\Api\Clients\ClientHomeController;
use App\Http\Controllers\Api\Clients\ClientPanierController;
use Illuminate\Support\Facades\Route;

Route::prefix('clients')->group(function () {



    Route::get('home-page', [ClientHomeController::class, 'homePage']);
    Route::get('menus-page', [ClientHomeController::class, 'menusPage']);
    Route::get('plat/{id}', [ClientHomeController::class, 'platById']);
    Route::get('menu/{id}', [ClientHomeController::class, 'menuById']);
    Route::get("search/{mot}", [ClientHomeController::class, "searchPlats"]);
    Route::get("search/", [ClientHomeController::class, "allPlats"]);

    Route::apiResource('clients/commandes', ClientCommandeController::class);
    Route::apiResource('paniers', ClientPanierController::class);
    Route::get('mes-commandes/{id}', [ClientCommandeController::class, 'mesCommandes']);
    Route::get('position-livreur/{id}', [ClientCommandeController::class, 'positionLivreur']);

    Route::get('communes', [ClientProfileController::class, 'communes']);
    Route::post('profile-update/{id}', [ClientProfileController::class, 'update']);
    Route::post('profile-adresse/{id}', [ClientProfileController::class, 'updateAdresse']);

    Route::post('new-user', [ClientsAuthController::class, 'registreEmail']);
    Route::post('clients', [ClientsAuthController::class, 'storeClient']);
    Route::post('login', [ClientsAuthController::class, 'login']);
    Route::post('token', [ClientsAuthController::class, 'newFcmToken']);
    Route::post('logout', [ClientsAuthController::class, 'logout']);
    Route::post('forget-password', [ClientsAuthController::class, 'verifyEmail']);
    Route::get('{id}', [ClientsAuthController::class, 'getUser']);
    Route::post('change-forget-password', [ClientsAuthController::class, 'changeForgetPassword']);
    Route::post('change-password', [ClientsAuthController::class, 'changePassword']);

});