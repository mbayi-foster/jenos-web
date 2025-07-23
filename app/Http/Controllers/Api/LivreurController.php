<?php

namespace App\Http\Controllers\Api;

use App\Enum\UserType;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\LivreurResource;
use App\Mail\WebMail;
use App\Models\Livreur;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class LivreurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livreurs = User::where('type', UserType::LIVREUR)->get();
        return ApiResponse::success(data: LivreurResource::collection($livreurs));
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
            'phone' => 'required|regex:/^\+[0-9]{6,15}$/',
            'zoneId' => 'required|exists:zones,id'
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
                'type' => UserType::LIVREUR,
            ]);

            if ($user) {
                Livreur::create([
                    'user_id' => $user->id,
                    'zone_id' => $validated['zoneId'],
                ]);
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

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'phone' => 'required|regex:/^\+[0-9]{6,15}$/',
            'zoneId' => 'required|exists:zones,id'
        ]);

        // return ApiResponse::success(data: $validated);

        $livreur = Livreur::where('user_id', $id)->first();
        if ($livreur != null) {
            $livreur->zone_id = $validated['zoneId'];
            $livreur->save();

            $profile = Profil::where('user_id', $id)->first();

            if ($profile != null) {
                $profile->nom = $validated['nom'];
                $profile->prenom = $validated['prenom'];
                $profile->phone = $validated['phone'];
                $profile->save();

                return ApiResponse::success();

            } else {
                return ApiResponse::error(code: 201);
            }
        } else {
            return ApiResponse::error();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $livreur = Livreur::findOrFail($id);
        if ($livreur) {
            $user = User::find($livreur->users->id);
            if ($user)
                $user->delete();
            $livreur->delete();
            return response()->json(true, 200);
        }
        return response()->json(["error" => "non trouvé"], 400);
    }

    public function change_status(string $id)
    {
        $livreur = Livreur::find($id);


        if ($livreur) {
            $user = User::find($livreur->users->id);

            $user->status = !$user->status;
            $user->save();
        }
        return response()->json(true, 200);
    }

    public function livreurByZone($id)
    {
        $livreurs = Livreur::where('zone_id', $id)
            ->get();
        if ($livreurs->isEmpty()) {
            return ApiResponse::error(message: 'No livreurs found for this zone', code: 404);
        }
        $users = [];
        foreach ($livreurs as $key => $value) {
            $users[] = User::find($value->user_id);
        }
        return ApiResponse::success(data: LivreurResource::collection($users), message: 'Livreurs retrieved successfully');
    }
}
