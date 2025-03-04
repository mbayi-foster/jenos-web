<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PlatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ZoneController;
use App\Mail\MobileMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
require __DIR__.'/auth.php';

//route admin

//route for users
Route::resource('/users', UserController::class);
Route::resource('/zones', ZoneController::class);
Route::resource('/plats', PlatController::class);
Route::resource('/commandes', CommandeController::class);
Route::post('users/change/{id}', [UserController::class, 'change'])->name('users.change');
Route::post('zones/change/{id}', [ZoneController::class, 'change'])->name('zones.change');
Route::post('plats/change/{id}', [PlatController::class, 'change'])->name('plats.change');

Route::get('dashboard/', [AdminController::class, 'index'])->name('admin.dashboard');

Route::get('/teste', function (){
    $data = ['nom'=>"Kalala", 'code'=>'354683', 'sujet'=>"Confirmez son email"];
   // Mail::to('jfkfostermbayi2@gmail.com')->send(new MobileMail($data));

    return view('email.web.new_user', compact('data'));
});