<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class MainController
{
    public function index()
    {
        $roles = Role::all();

        if ($roles->count() == 0) {
            $roles = [
                "Adiminstrateur",
                "Gérant",
                "Livreur"
            ];

            foreach ($roles as $role) {
                Role::create([
                    "nom" => $role,
                    "status"=>true,
                ]);
            }
        }
        $rootUser = User::where('email', 'admin@jenos-food.top')->first();

        if(!$rootUser){
            $roles = [1,2,3];
            $user = User::create([
                'nom' => "Root",
                'prenom' => "Adiminstrateur",
                'email' => "admin@jenos-food.top",
                'password' => bcrypt('admin'),
            ]);
    
            if ($user) {
                $user->roles()->attach($roles);
        }
    }

    return view("welcome");
}
}
