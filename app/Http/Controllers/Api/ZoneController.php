<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zonesdB = Zone::with('chefs')->get();
        $zones = [];
        foreach ($zonesdB as $zone) {
        $gerant = $zone->chefs->prenom . " ". $zone->chefs->nom;
        $zones[]= [
            'id'=> $zone->id,
            'nom'=> $zone->nom,
            "status"=> $zone->status,
            "gerant"=> $gerant
        ];
        }
        return response()->json($zones, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $request->validate([
            "nom"=> "required",
            "gerant"=> "required",
        ]);
        $zones = Zone::create(
            [
                "nom" => $request->nom,
                "chef"=> $request->gerant
            ]
        );

        return response()->json(true, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $zone = Zone::find($id);
        return response()->json([
            "id" => $zone->id,
            "nom" => $zone->nom,
            "chef" => $zone->chef,
            "status" => $zone->status,
        ]);
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

    public function change_status(string $id)
    {
        $zone = Zone::find($id);

        if ($zone->status == true) {
            $zone->status = false;
        } else {
            $zone->status = true;
        }

        $zone->save();
        return response()->json($zone);
    }
}
