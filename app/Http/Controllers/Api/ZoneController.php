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
        $zonesDB = Zone::all();
        $zones = $zonesDB->map(fn($zone) => $zone->toArray());
        return response()->json($zones, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nom" => "required",
            "gerant" => "required",
        ]);
        $zones = Zone::create(
            [
                "nom" => $request->nom,
                "chef" => $request->gerant
            ]
        );

        return response()->json($request, 201);
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
        $zone = Zone::find($id);
        if ($zone) {
            $zone->delete();
            return response()->json(true, 200);
        }
        return response()->json(false, 404);
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

    public function zone_by_id(string $id)
    {
        $zonesDb = Zone::where('chef', $id)->get();
        $zones = $zonesDb->map(
            fn($zone) =>
            [
                'id' => $zone->id,
                'nom' => $zone->nom
            ]
        );

        return response()->json($zones, 200);
    }
}
