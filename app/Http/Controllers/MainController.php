<?php

namespace App\Http\Controllers;

use App\Models\Admin;
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
                "Administrateur",
                "Gérant"
            ];

            foreach ($roles as $role) {
                Role::create([
                    "nom" => $role,
                    "status" => true,
                ]);
            }
        }

        $rootUser = User::where('email', 'admin@jenos-food.store')->first();

        if (!$rootUser) {
            $roles = Role::all();
            $roles = $roles->map(fn($role) => $role->id);
            $user = User::create([
                // 
                'email' => "admin@jenos-food.store",
                'password' => bcrypt('@jenos$'),
            ]);

            if ($user) {
                $admin = Admin::create([
                    'nom' => "Root",
                    'prenom' => "Utilisateur",
                    'user_id'=>$user->id,
                ]);
                if($admin) $admin->roles()->attach($roles);
            }
        }

        return view("welcome");
    }
}
