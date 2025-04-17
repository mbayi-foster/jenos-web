<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plat;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PlatController extends Controller
{
    private $url;

    public function __construct()
    {
        $this->url = env("APP_URL");
    }
    /**
     * Display a listing of the resource.
     * Recuperer tous les plats
     */
    public function index()
    {
        $platsDb = Plat::all();
        $plats = $platsDb->map(fn($plat) => $plat->toArray());

        return response()->json($plats);
    }

    /**
     * Store a newly created resource in storage.
     * Creer un plat
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prix' => 'required|numeric',
            'details' => 'required',
            'photo' => 'required|image',
        ]);

        if ($request->file('photo')) {

            $timestamp = time();
            $newName = $request->nom . '_' . $timestamp . '.' . $request->file('photo')->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs('images/plats', $newName, 'public');
            $plat = Plat::create([
                "nom" => $request->nom,
                "prix" => $request->prix,
                "photo" => $path,
                "details" => $request->details
            ]);

            return response()->json($plat, 201);
        } else {
            return response()->json(['error' => 'Aucune photo téléchargée.'], 400);
        }






    }

    /**
     * Display the specified resource.
     * Recuperer un plat par son id
     */
    public function show(string $id)
    {
        $plat = Plat::find($id);
        return response()->json($plat, 200);
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
     * Supprimer le plat
     */
    public function destroy(string $id)
    {
        $plat = Plat::findOrFail($id);
        if ($plat) {
            $plat->delete();

            return response()->json(true, 200);
        }

        return response()->json(["error" => "non trouvé"], 400);
    }

    /* changement du status du plat */
    public function change_status(string $id)
    {
        $plat = Plat::find($id);

        $plat->status = $plat->status == true ? false : true;
        $plat->save();
        return response()->json($plat);
    }

    
    public function plats_status()
    {
        $plats = Plat::where("status", 1)->get();
        $nouveauPlats = [];
        foreach ($plats as $plat) {
            $nouveauPlats[] = [
                'id' => $plat->id,
                'nom' => $plat->nom
            ];
        }
        return response()->json($nouveauPlats, 200);
    }

    public function search(string $mot, Request $request){
        
    }
}
