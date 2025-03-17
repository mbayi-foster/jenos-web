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
     */
    public function index()
    {
        $platsDb = Plat::all();
        $plats = [];

        foreach ($platsDb as $plat) {
            $url = Storage::disk('public')->url($plat->photo);
            if (strpos($url, 'http://localhost') !== false) {
                $url = str_replace('http://localhost', 'http://localhost:8000', $url); // Remplacez par le port approprié
            }
            $plats[] = [
                "id" => $plat->id,
                "nom" => $plat->nom,
                "photo" => $url,
                "status" => $plat->status,
                "prix" => $plat->prix,
                "commandes" => $plat->commandes,
                "like" => $plat->like
            ];
        }
        return response()->json($plats);
    }

    /**
     * Store a newly created resource in storage.
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
     */
    public function show(string $id)
    {
        $plat = Plat::find($id);
        $url = Storage::disk('public')->url($plat->photo);
        if (strpos($url, 'http://localhost') !== false) {
            $url = str_replace('http://localhost', $this->url.":8000", $url); // Remplacez par le port approprié
        }
        $date = new DateTime($plat->created_at);
        setlocale(LC_TIME, 'fr_FR.UTF-8');
        return response()->json([
            "id" => $plat->id,
            "nom" => $plat->nom,
            "prix" => $plat->prix,
            "photo" => $url,
            "details" => $plat->details,
            "status" => $plat->status,
            "like" => $plat->like,
            "commandes" => $plat->commandes,
            "date" => strftime('%A, %d %B %Y à %Hh%M', $date->getTimestamp())
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
        $plat = Plat::findOrFail($id);
        if ($plat) {
            $plat->delete();

            return response()->json(true, 200);
        }

        return response()->json(["error" => "non trouvé"], 400);
    }

    public function change_status(string $id)
    {
        $plat = Plat::find($id);

        if ($plat->status == true) {
            $plat->status = false;
        } else {
            $plat->status = true;
        }

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
}
