<?php

namespace App\Http\Controllers\Api\User;

use App\Enum\UserType;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Mail\WebMail;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users|max:255',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'password' => 'required|min:6|max:15',
            'phone' => 'required|regex:/^\+?[0-9\s\-]{6,20}$/', // Exemple de validation
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
            'type' => 'required|string',
        ]);

        $type = null;

        switch ($validated['type']) {
            case 'client':
                $user = User::create([
                    'email' => $validated['email'],
                    'password' => bcrypt($validated['password']),
                    'type' => UserType::CLIENT
                ]);

                if ($user) {
                    Profil::create([
                        'user_id' => $user->id,
                        'nom' => $validated['nom'],
                        'prenom' => $validated['prenom'],
                        'phone' => $validated['phone'],
                    ]);

                    return ApiResponse::success(message: 'Client enregistré avec succès', code: 201);
                }
                return ApiResponse::error('L\'utilisateur n\'a pas pu être créé');
            case 'admin':

                $data = [
                    'nom' => $validated['nom'],
                    'prenom' => $validated['prenom'],
                    'phone' => $validated['phone'],
                    "email" => $validated['email'],
                    "password" => $validated['password'],
                    'sujet' => "Confirmatiom du compte"
                ];
                $sendMail = Mail::to($request->email)->send(new WebMail($data));
                $user = User::create([
                    'email' => $validated['email'],
                    'password' => bcrypt($validated['password']),
                    'type' => UserType::ADMIN
                ]);
                if ($user) {
                    $user->roles()->attach($validated['roles']);
                    Profil::create([
                        'user_id' => $user->id,
                        'nom' => $validated['nom'],
                        'prenom' => $validated['prenom'],
                        'phone' => $validated['phone'],
                    ]);
                    return ApiResponse::success(message: 'Adminstrateur enregistré avec succès', code: 201);
                }
                return ApiResponse::error('L\'utilisateur n\'a pas pu être créé');
            case 'livreur':
                $type = UserType::LIVREUR;
                break;
            default:
                $type = UserType::CLIENT;
                break;
        }




    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
