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
            'commune'=>'required',
            'location_lat' => 'required',
            'location_lon' => 'required',
            'id' => "required|exists:clients,id"
        ]);

        $client = Client::find($validated['id']);
        if ($client) {
            $client->adresse = $validated['adresse'];
            $client->location_lat = $validated['location_lat'];
            $client->location_lon = $validated['location_lon'];
            $client->commune = $validated['commune'];
            $client->save();
        }
        return response()->json($client->toArray(), 201);

    }
}
