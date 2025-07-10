<?php

namespace App\Http\Controllers\Api;

use App\Enum\UserStatus;
use App\Enum\UserType;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Mail\WebMail;
use App\Mail\CheckMail;
use App\Models\Admin;
use App\Models\Profil;
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
        $users = User::where('type', UserType::ADMIN)
            ->with('profile')
            ->get();

        return ApiResponse::success(
            data: AdminResource::collection($users),
            code: 200
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users|max:255',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'phone' => 'required|regex:/^\+?[0-9\s\-]{6,20}$/', // Exemple de validation
            'roles' => 'required|array', // Assurez-vous que 'roles' est un tableau
            'roles.*' => 'exists:roles,id',
        ]);
        $data = [
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'phone' => $validated['phone'],
            "email" => $validated['email'],
            "password" => "@jenos$",
            'sujet' => "Confirmatiom du compte"
        ];
        $sendMail = Mail::to($request->email)->send(new WebMail($data));
        if ($sendMail) {
            $user = User::create([
                'email' => $validated['email'],
                'password' => bcrypt('@jenos$'),
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


                return ApiResponse::success(code: 201, message: "Adminstrateur enregistré avec succès");
            } else {
                return ApiResponse::error(message: "L'administrateur n'a pas pu être enregistré", code: 500);
            }
        }

        return ApiResponse::error(message: "L'administrateur n'a pas pu être enregistré", code: 500);
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
        $user = User::findOrFail($id);

        $user->status = $user->status === UserStatus::ACTIVE
            ? UserStatus::INACTIVE
            : UserStatus::ACTIVE;

        $user->save();

        return ApiResponse::success($user, 'succès', 200);

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
        if ($user && Hash::check($password, $user->password) && $user->status == UserStatus::ACTIVE && $user->type == UserType::ADMIN) {
            // $token = $user->createToken("admin-$user->email")->plainTextToken;
            // $admin = Admin::where('user_id', $user->id)->first();
            // $admin_login = $admin->toArray();
            // $admin_login["token"] = $token;
            return ApiResponse::success(new AdminResource($user));
        }
        return ApiResponse::error(message: 'Adresse email ou Mot de passe incorrecte');
    }

    public function logout(Request $request)
    {
    }

    public function check_mail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $code = rand(100000, 999999);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $data = ['code' => $code, "sujet" => "Confirmer l'adresse email"];
            Mail::to($request->email)->send(new CheckMail($data));
            return response()->json([
                "code" => $code,
            ], 200); // Retourner un objet JSON
        } else {
            return response()->json(['msg' => 'Adresse email non reconnue.'], 500); // Retourner un objet JSON
        }
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:15'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json("succès", 201);
        }
        return response()->json("echec", 500);
    }
}
