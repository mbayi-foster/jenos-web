<?php

namespace App\Http\Controllers\Api\User;

use App\Enum\UserType;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
            'phone' => 'numeric|digits_between:9,15', // Exemple de validation
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
            'type' => 'required|string',
        ]);

        $type = null;

        switch ($validated['type']) {
            case 'client':
                $type = UserType::CLIENT;
                break;
            case 'admin':
                $type = UserType::ADMIN;
                break;
            case 'livreur':
                $type = UserType::Livreur;
                break;
            default:
                $type = UserType::CLIENT;
                break;
        }

        $user = User::create([
            'email' => $validated['email'],
            'password' => $validated['password'],
            'type' => $type
        ]);

        if ($user) {
            
        }

        return ApiResponse::error('L\'utilisateur n\'a pas pu être créé');
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
