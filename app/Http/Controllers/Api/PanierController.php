<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Panier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PanierController extends Controller
{
    private $url;
    private $photo = "https://cdn.pixabay.com/photo/2024/09/15/13/03/cows-9049119_1280.jpg";


    public function __construct()
    {
        $this->url = env("APP_URL");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paniers = Panier::all();
        return response()->json($paniers, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "client_id" => "required|exists:clients,id",
            "plat_id" => "required|exists:plats,id,status,1",
            "qte" => "required",
            "prix" => "required",
        ]);

        $panier = Panier::where("client_id", $validated['client_id'])->where("plat_id", $validated["plat_id"])->first();
        if ($panier) {
            $panier->prix += $validated["prix"];
            $panier->qte += $validated["qte"];
            $panier->save();
            return response()->json($panier, 201);
        } else if (!$panier) {
            $panier = Panier::create(
                [
                    "prix" => $validated["prix"],
                    "client_id" => $validated["client_id"],
                    "plat_id" => $validated["plat_id"],
                    "qte" => $validated["qte"],

                ]
            );
            return response()->json(true, 201);
        }


        return response()->json(false, 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $panier_before = Panier::where("client_id", $id)->with("plats")->get();
        $paniers = [];
        foreach ($panier_before as $panier) {
            $plat = $panier->plats;
            $url = Storage::disk('public')->url($plat->photo);
            if (strpos($url, 'http://localhost') !== false) {
                $url = str_replace('http://localhost', 'http://localhost:8000', $url); // Remplacez par le port approprié
            }
            $paniers[] = [
                "id"=>$panier->id,
                "client_id"=>$panier->id,
                "status"=>$panier->status,
                "prix"=>$panier->prix,
                "qte"=>$panier->qte,
                "created_at"=>$panier->created_at,
                "plat" => [
                    "id" => $plat->id,
                    'nom' => $plat->nom,
                    'details' => $plat->details,
                    "like" => $plat->like,
                    'photo' => $this->photo, //$url,
                    'qte' => $plat->qte,
                    'prix' => $plat->prix,
                    'created_at' => $plat->created_at
                ],

            ];
        }
        return response()->json($paniers, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Panier $panier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $panier = Panier::where("id", $id)->first();

        if ($panier) {
            $panier->delete();
            return response()->json(true, 200);
        } else {
            return response()->json(false, 500);
        }
    }
}
