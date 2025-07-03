<?php

namespace App\Http\Controllers\Api;

use App\Enum\UserStatus;
use App\Enum\UserType;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Mail\MobileMail;
use App\Models\Profil;
use App\Models\User;
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
        $clients = User::where("type", UserType::CLIENT)->get();
        // $clients = User::all();
        return ApiResponse::success(data: ClientResource::collection($clients));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valide = $request->validate([
            'email' => 'required|unique:users|max:255',
            'nom' => 'required',
            'prenom' => 'required',
            'phone' => 'required|regex:/^\+[0-9]{12}$/',
            'password' => 'required|min:6',
        ]);
        $user = User::create([
            'email' => $valide['email'],
            'password' => bcrypt($valide['password']),
        ]);

        if ($user) {
            Profil::create([
                'nom' => $valide['nom'],
                'prenom' => $valide['prenom'],
                'phone' => $valide['phone'],
                'user_id' => $user->id
            ]);
            // $token = $user->createToken("client-$user->email")->plainTextToken;
            // $client = $client->toArray();
            // $client["token"] = $token;
            return ApiResponse::success(data: ClientResource::resource($user));
        }
        return ApiResponse::error(data: $request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('id', $id)->where('type', UserType::CLIENT)->first();

        return ApiResponse::success(data: new ClientResource($user));
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

        $client = Profil::where('user_id', $id)->first();

        if ($client) {
            $client->nom = $validated['nom'];
            $client->prenom = $validated['prenom'];
            $client->phone = $validated['phone'];
            $client->save();
            return ApiResponse::success(data: new ClientResource(User::find($id)));
        }

        return ApiResponse::error();
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
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password) && $user->status == UserStatus::ACTIVE && $user->type == UserType::CLIENT) {
            // $token = $user->createToken("client-$user->email")->plainTextToken;
            // $client = Client::where('user_id', $user->id)->first();
            // $client_login["token"] = $token;
            return ApiResponse::success(data: ClientResource::resource($user));
        }
        return ApiResponse::error(message: 'Mot de passe ou adresse email incorrecte');
    }

    public function newUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users|max:255',
            'nom' => 'required|string|max:255'
        ]);
        $code = rand(100000, 999999);
        $data = ['nom' => $request->nom, 'code' => $code, "sujet" => "Confirmer l'adresse email"];
        Mail::to($request->email)->send(new MobileMail($data));

        return ApiResponse::success(data: [
            "code" => $code,
        ], code: 200);

    }


}
