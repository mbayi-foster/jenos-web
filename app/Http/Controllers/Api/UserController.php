<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\WebMail;
use App\Jobs\SendEmailJob;
use App\Models\Admin;
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
        $useDB = Admin::all();
        $admins = $useDB->map(fn($user) => $user->toArray());
        return response()->json($admins, 200);
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
            'email' => $validated['email'],
            'password' => bcrypt('123456'),
        ]);

        if ($user) {
            $admin = Admin::create([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'phone' => $validated['phone'],
                'user_id' => $user->id,
            ]);
            if ($admin) {
                $admin->roles()->attach($validated['roles']);
                $data = [
                    'nom' => $admin->nom,
                    'prenom' => $admin->prenom,
                    'phone' => $admin->phone,
                    "email" => $admin->users->email,
                    "password" => "123456",
                    'sujet' => "Confirmatiom du compte"
                ];
                //  SendEmailJob::dispatch($user->email, $data);
                Mail::to($user->email)->send(new WebMail($data));
                return response()->json($admin, 200);
            }
            return response()->json(false, 500);
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
        $user = Admin::with('roles')->findOrFail($id);
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
        $admin = Admin::findOrFail($id);

        if ($admin) {
            $admin->phone = $validated['phone'];
            $admin->nom = $validated['nom'];
            $admin->prenom = $validated['prenom'];
            $admin->roles()->detach();
            $admin->roles()->attach($validated['roles']);
            $admin->save();
            return response()->json(true, 200);
        }
        return response()->json($validated, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = Admin::findOrFail($id);
        if ($admin) {
            $user = User::find($admin->users->id);
            if ($user)
                $user->delete();
            $admin->delete();
            return response()->json(true, 200);
        }

        return response()->json(["error" => "non trouvé"], 400);
    }

    public function change_status(string $id)
    {
        $admin = Admin::find($id);

        if ($admin) {
            $user = User::find($admin->users->id);
            $user->status = $user->status ? false : true;
            $admin->status = $admin->status ? false : true;
            $user->save();
            $admin->save();
        }


        return response()->json(true, 200);
    }

    public function gerants()
    {
        $gerants = Admin::where('status', true)->whereHas('roles', function ($query) {
            $query->where('nom', 'gérant');
        })->get();

        $nouveauGerants = $gerants->map(fn($gerant) => [
            'id' => $gerant->id,
            'nom' => "$gerant->prenom $gerant->nom"
        ]);
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
        if ($user && Hash::check($password, $user->password) && $user->status == true) {
            $token = $user->createToken("admin-$user->email")->plainTextToken;
            $admin = Admin::where('user_id', $user->id)->first();
            $admin_login =  $admin->toArray();
            $admin_login["token"] = $token;
            return response()->json($admin_login, 201);
        }
        return response()->json(false, 500);
    }

    public function logout(Request $request)
    {

    }
}