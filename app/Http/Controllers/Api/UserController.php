<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with("roles")->get();
        if ($users) {
            return response()->json($users, 200);
        }
        return response()->json(null, 500);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|unique:users|max:255',
            'nom' => 'required',
            'prenom' => 'required',
            'phone' => 'required',
        ]);
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt('12345678'),
            'phone' => $request->phone
        ]);

        return response()->json($user, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = [];
        foreach ($user->roles as $role) {
            $roles[$role->id] = $role->nom;
        }
        return response()->json([
            "nom" => $user->nom,
            "prenom" => $user->prenom,
            "email" => $user->email,
            "phone" => $user->phone,
            "roles" => $roles,
            "status" => $user->status,
            "id" => $user->id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user =  User::findOrFail($id);

        if($user){
            $user->delete();
            return response()->json(true, 200);
        }
        return response()->json(false, 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function change_status(string $id)
    {
        $user = User::find($id);

        if ($user->status == true) {
            $user->status = false;
        } else {
            $user->status = true;
        }

        $user->save();
        return response()->json($user);
    }

    public function gerants()
    {
        $gerants = User::whereHas('roles', function ($query) {
            $query->where('nom', 'admin');
        })->get();

        $nouveauGerants = [];
        foreach ($gerants as $gerant) {
            $nouveauGerants[] = [
                'id' => $gerant->id,
                'nom' => "$gerant->prenom $gerant->nom"
            ];
        }
        return response()->json($nouveauGerants, 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);
        $password = $request->password;
        $user = User::where("email", $request->email)->first();

        if ($user && Hash::check($password, $user->password)) {
            return response()->json([
                "nom" => $user->nom,
                "prenom" => $user->prenom,
                "email" => $user->email,
                "id" => $user->id,
                "created_at" => $user->created_at,
                "photo" => $user->photo,
                "phone" => $user->phone,
                "status" => $user->status
            ], 201);
        }
        return response()->json(false, 500);
    }
}