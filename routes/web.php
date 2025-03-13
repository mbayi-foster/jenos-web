<?php
use App\Http\Controllers\MainController;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get("/", [MainController::class, "index"])->name("index");

Route::get('/teste', function () {
    $data = ['nom' => "Kalala", 'code' => '354683', 'sujet' => "Confirmez son email"];
    // Mail::to('jfkfostermbayi2@gmail.com')->send(new MobileMail($data));

    return view('email.web.new_user', compact('data'));
});