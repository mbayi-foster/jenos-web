<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('users.admin.list-person', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.create-person',);
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
        $user =  User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt('12345678'),
            'phone' => $request->phone
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.admin.user', compact('user'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function change(Request $request, string $id)
    {
        $user = User::with('roles')->findOrFail($id);
        $userRoles = $user->roles;
        if (isset($request->roles)) {
            $roles = $request->roles;
            foreach ($roles as $role) {
                $rol = Role::where('id', $role)->first();
                if (!$user->roles()->where('role_id', $role)->exists()) {
                    $user->roles()->attach($rol->id);
                }
            }

            foreach ($userRoles as $userRol) {
                $idRoles = $userRol->id;
                if (!in_array($idRoles, $roles)) {
                    $user->roles()->detach($userRol);
                }
            }
        } else {
            $user->roles()->detach();
        }
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->phone = $request->phone;
        $user->save();
        return redirect()->back()->with('success', 'Mis à jour réussie !');
    }

    public function teste(){
        return view('email.auth.create');
    }
}
