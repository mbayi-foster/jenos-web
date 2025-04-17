<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\MobileMailJob;
use App\Mail\MobileMail;
use App\Models\Client;
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
        $clients = Client::all();
        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valide = $request->validate([
            'email' => 'required|unique:clients|max:255',
            'nom' => 'required',
            'prenom' => 'required',
            'phone' => 'required|regex:/^[0-9]{10}$/',
            'password' => 'required|min:6',
        ]);
        $user = Client::create([
            'nom' => $valide['nom'],
            'prenom' => $valide['prenom'],
            'email' => $valide['email'],
            'password' => bcrypt($valide['password']),
            'phone' => $valide['phone']
        ]);

        if ($user) {
            $token = $user->createToken("client-$user->email")->plainTextToken;
            $client = $user->toArray();
            $client["token"]=$token;
            return response()->json($client, 201);
            
        }
        return response()->json(false, 500);
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
        $validated = $request->validate([
            "nom" => "required",
            "prenom" => "required",
            "phone" => "required"
        ]);

        $user = Client::find($id);

        if ($user) {
            $user->nom = $validated['nom'];
            $user->prenom = $validated['prenom'];
            $user->phone = $validated['phone'];

            $user->save();

            return response()->json($user->toArray(), 201);
        }

        return response()->json(false, 500);
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
            $token = $user->createToken("client-$user->email")->plainTextToken;
            $client = $user->toArray();
            $client["token"]=$token;
            return response()->json($client, 200);
        }
        return response()->json(null, 500);
    }

    public function newUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'nom' => 'required|string|max:255'
        ]);
        $code = rand(100000, 999999);
        $user = Client::where('email', $request->email)->first(); // Correction ici

        if (!$user) {
            $data = ['nom' => $request->nom, 'code' => $code, "sujet" => "Confirmer l'adresse email"];
            Mail::to($request->email)->send(new MobileMail($data));
            // MobileMailJob::dispatch($request->email, $data);
            return response()->json([
                "code" => $code,
            ], 200); // Retourner un objet JSON
        } else {
            return response()->json(['msg' => 'Cet utilisateur existe déjà en cas de mot de passe oublié veillez suivre la procedure'], 200); // Retourner un objet JSON
        }

    }

}
