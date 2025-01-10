<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::with('chefs')->get();
        $gerants = User::whereHas('roles', function ($query) {
            $query->where('nom', 'Gérant'); // Assure-toi que "name" correspond à la colonne de ton rôle
        })->get();
      //  return response()->json($zones);
        return view('users.admin.zones', compact('zones', 'gerants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gerants = User::whereHas('roles', function ($query) {
            $query->where('nom', 'Gérant'); // Assure-toi que "name" correspond à la colonne de ton rôle
        })->get();
        return view('users.admin.create-zones', compact('gerants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $zones = Zone::create(
            [
                "nom" => $request->nom,
                "chef"=> $request->gerant
            ]
        );

        return redirect()->route('zones.index')->with('success', 'Zones créée avec succès   ');
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        //
    }
    public function change(Request $request, string $id){
        $zone = Zone::find($id);
        $zone->nom = $request->nom;
        $zone->chef = $request->gerant;
        $zone->save();
        return redirect()->back()->with('success', 'Mis à jour réussie !');
    }
}
