<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\MobileMail;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthClientController extends Controller
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
        // $user = $request->session()->all();
        /* $request->validate([
            'email' => 'required|unique:clients|max:255',
            'nom' => 'required',
            'prenom' => 'required',
            'phone' => 'required|regex:/^[0-9]{10}$/', // Ajustez selon vos besoins
            'password' => 'required|min:6',
        ]);
        $user = Client::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone
        ]);

        if ($user) {
            return response()->json(true, 200);
        }
        return response()->json($request, 500); */
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

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = Client::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password) && $user->status == true) {
            return response()->json([
                "nom" => $user->nom,
                "prenom" => $user->prenom,
                "email" => $user->email,
                "id" => $user->id,
                "created_at" => $user->created_at,
                "photo" => $user->photo,
                "phone" => $user->phone,
                "status" => $user->status
            ], 200);
        }
        return response()->json(null, 500);
    }

    public function newUser(Request $request)
    {
       /*  $request->validate([
            'email' => 'required|email',
            'nom' => 'required|string|max:255'
        ]); */
        $code = rand(100000, 999999);
        $user = Client::where('email', $request->email)->first(); // Correction ici

        if (!$user) {
            Mail::to($request->email)->send(new MobileMail(['nom' => $request->nom, 'code' => $code, "sujet" => "Confirmer l'adresse email"]));
            return response()->json([
                "code" => $code,
            ], 200); // Retourner un objet JSON
        } else {
            return response()->json(['msg' => 'Cet utilisateur existe déjà en cas de mot de passe oublié veillez suivre la procedure'], 200); // Retourner un objet JSON
        }

    }
}
