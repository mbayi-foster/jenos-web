<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\WebMail;
use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $useDB = User::all();
        $users = $useDB->map(fn($user) => $user->toArray());
        return response()->json($users, 200);
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
            'email' => 'required|email|unique:users|max:255',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:9,15', // Exemple de validation
            'roles' => 'required|array', // Assurez-vous que 'roles' est un tableau
            'roles.*' => 'exists:roles,id',
        ]);
        $user = User::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'password' => bcrypt('123456'),
            'phone' => $validated['phone']
        ]);

        if ($user) {
            $user->roles()->attach($validated['roles']);
            $data = [
                'nom' => $user->nom,
                'prenom' => $user->prenom,
                'phone' => $user->phone,
                "email" => $user->email,
                "password" => "123456",
                'sujet' => "Confirmatiom du compte"
            ];
            //  SendEmailJob::dispatch($user->email, $data);
            Mail::to($user->email)->send(new WebMail($data));
            return response()->json($user, 200);
        } else {
            return response()->json(false, 500);
        }
        // return response()->json($request->all(), 201);
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
        $validated = $request->validate([
            // 'email' => 'required|email|unique:users|max:255',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:9,15', // Exemple de validation
            'roles' => 'required|array', // Assurez-vous que 'roles' est un tableau
            'roles.*' => 'exists:roles,id',
        ]);
        $user = User::findOrFail($id);

        if ($user) {
            $user->phone = $validated['phone'];
            $user->nom = $validated['nom'];
            $user->prenom = $validated['prenom'];
            $user->roles()->detach();
            $user->roles()->attach($validated['roles']);
            $user->save();
            return response()->json(true, 200);
        }
        return response()->json($validated, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $user->delete();

            return response()->json(true, 200);
        }

        return response()->json(["error" => "non trouvé"], 400);
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
            $query->where('nom', 'gérant');
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
            $token = $user->createToken("client-$user->email")->plainTextToken;
            $userLogin = $user->toArray();
            $userLogin["token"]=$token;
            return response()->json($userLogin, 201);
        }
        return response()->json(false, 500);
    }
}