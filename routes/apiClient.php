<?php

use App\Http\Controllers\Api\Clients\ClientProfileController;
use App\Http\Controllers\Api\Clients\AuthClientController as ClientsAuthController;
use App\Http\Controllers\Api\Clients\ClientCommandeController;
use App\Http\Controllers\Api\Clients\ClientHomeController;
use App\Http\Controllers\Api\Clients\ClientPanierController;
use Illuminate\Support\Facades\Route;

Route::get('/clients/home-page', [ClientHomeController::class, 'homePage']);
Route::get('/clients/menus-page', [ClientHomeController::class, 'menusPage']);
Route::get('/clients/plat/{id}', [ClientHomeController::class, 'platById']);

Route::apiResource('clients/commandes', ClientCommandeController::class);
Route::apiResource('/clients/paniers', ClientPanierController::class);
Route::get('/clients/mes-commandes/{id}', [ClientCommandeController::class, 'mesCommandes']);
Route::get('/clients/position-livreur/{id}', [ClientCommandeController::class, 'positionLivreur']);

Route::post('/clients/profile-update/{id}', [ClientProfileController::class, 'update']);
Route::post('/clients/profile-adresse/{id}', [ClientProfileController::class, 'updateAdresse']);

Route::post('/clients/new-user', [ClientsAuthController::class, 'registreEmail']);
Route::post('/clients', [ClientsAuthController::class, 'storeClient']);
Route::post('/clients/login', [ClientsAuthController::class, 'login']);
Route::post('/clients/forget-password', [ClientsAuthController::class, 'verifyEmail']);
Route::get('/clients/{id}', [ClientsAuthController::class, 'getUser']);
Route::post('/clients/change-forget-password', [ClientsAuthController::class, 'changeForgetPassword']);
Route::post('/clients/change-password', [ClientsAuthController::class, 'changePassword']);
