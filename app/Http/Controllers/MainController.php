<?php

namespace App\Http\Controllers;

use App\Enum\Roles;
use App\Enum\UserType;
use App\Helpers\ApiResponse;
use App\Models\Admin;
use App\Models\Profil;
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
                Roles::ADMIN,
                Roles::GERANT
            ];

            foreach ($roles as $role) {
                Role::create([
                    "nom" => $role,
                    "status" => true,
                ]);
            }
        }

        $rootUser = User::where('email', 'root@jenos-food.store')->first();

        if (!$rootUser) {
            $roles = Role::all();
            $roles = $roles->map(fn($role) => $role->id);
            $user = User::create([
                'email' => "root@jenos-food.store",
                'password' => bcrypt('@jenos-food$'),
                'type' => UserType::ADMIN,
            ]);

            if ($user) {
                $user->roles()->attach($roles);
                Profil::create([
                    'user_id' => $user->id,
                    'nom' => 'Root',
                    'prenom' => 'Utilisateur',
                ]);
                
            }
        }

        return ApiResponse::success(null, "Initialisation de l'application réussie", 200);
    }
}
