<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'adresse' => 'required',
            'location_lat' => 'required',
            'location_lon' => 'required',
            'id' => "required|exists:clients,id"
        ]);

        $client = Client::find($validated['id']);
        if ($client) {
            $client->adresse = $validated['adresse'];
            $client->location_lat = $validated['location_lat'];
            $client->location_lon = $validated['location_lon'];

            $client->save();
        }
        return response()->json([
            'id' => $client->id,
            'prenom' => $client->prenom,
            'nom' => $client->nom,
            'email' => $client->email,
            'phone' => $client->phone,
            'status' => $client->status,
            'created_at' => $client->created_at,
            'adresse' => [
                'adresse' => $client->adresse,
                'lat' => $client->location_lat,
                'lon' => $client->location_lon
            ]
        ], 201);

    }
}
