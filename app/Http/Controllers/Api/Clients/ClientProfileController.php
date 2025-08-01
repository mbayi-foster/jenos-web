<?php

namespace App\Http\Controllers\Api\Clients;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommuneResource;
use App\Models\Commune;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Http\Request;

class ClientProfileController extends Controller
{

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'prenom' => 'required|string',
            'nom' => 'required|string',
            'phone' => 'required|regex:/^\+[0-9]{6,15}$/',
        ]);

        $user = Profil::where('user_id', $id)->first();
        if ($user != null) {
            $user->nom = $validated['nom'];
            $user->prenom = $validated['prenom'];
            $user->phone = $validated['phone'];
            $user->save();
            return ApiResponse::success(code: 201, data: $user);
        }

        return ApiResponse::error();
    }

    public function updateAdresse(Request $request, string $id)
    {
        $validated = $request->validate([
            'adresse' => 'required|string',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'commune' => 'required|string',
        ]);

        $user = Profil::where('user_id', $id)->first();
        if ($user != null) {
            $user->adresse = $validated['adresse'];
            $user->latitude = $validated['latitude'];
            $user->longitude = $validated['longitude'];
            $user->commune = $validated['commune'];
            $user->save();
            return ApiResponse::success(code: 201, data: $user);
        }

        return ApiResponse::error();
    }

    public function communes()
    {
        $communes = Commune::where('status', true)->get();

        return ApiResponse::success(data: CommuneResource::collection($communes));
    }


}
