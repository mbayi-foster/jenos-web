<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plat;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'nom' => 'required',
            'prix' => 'required|numeric',
            'details' => 'required',
            'photo' => 'image'
        ]);
        $plat = Plat::find($id);
        if ($plat) {
            if ($request->file('photo')) {
                $timestamp = time();
                $newName = $request->nom . '_' . $timestamp . '.' . $request->file('photo')->getClientOriginalExtension();
                $path = $request->file('photo')->storeAs('images/plats', $newName, 'public');
                $plat->nom = $request->nom;
                $plat->prix = $request->prix;
                $plat->photo = $path;
                $plat->details = $request->details;
                $plat->save();
                return response()->json($plat, 201);
            } else {
                $plat->nom = $request->nom;
                $plat->prix = $request->prix;
                $plat->details = $request->details;
                $plat->save();
            }
        }
        return response()->json($plat, 201);

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

    public function search(string $mot, Request $request)
    {
        $request->validate([
            "order" => 'string'
        ]);
        $query = "SELECT * FROM plats ORDER BY created_at DESC";
        if ($request->order)
            match ($request->order) {
                "new" => $query = " SELECT * FROM plats WHERE status = true AND nom LIKE '%$mot%' ORDER BY created_at DESC",
                "chers" => $query = " SELECT * FROM plats WHERE status = true AND nom LIKE '%$mot%' ORDER BY prix DESC",
                "moins" => $query = " SELECT * FROM plats WHERE status = true AND nom LIKE '%$mot%' ORDER BY prix ASC",
            };
      
        $plats = DB::select(
            $query
        );
        return response()->json($plats);
    }

    public function all(Request $request)
    {
        $request->validate([
            "order" => 'required|string'
        ]);
        $plats = [];
        match ($request->order) {
            "chers"=>$plats = Plat::orderByDesc('prix')->get(),
            "moins"=>$plats = Plat::orderBy('prix', 'ASC')->get(),
            "new"=>$plats = Plat::where('status', true)->orderBy('created_at', 'desc')->take(5)->get(),
            "desirs"=> $plats= Plat::withCount('paniers') // Assurez-vous que la relation 'paniers' est définie dans le modèle Plat
            ->orderBy('paniers_count', 'desc')
            ->limit(5)
            ->get()
        };
        return response()->json($plats);
    }
}
