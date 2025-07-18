<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
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
            "client_id" => "required|exists:users,id",
            "plat_id" => "required|exists:plats,id,status,1",
            "qte" => "required",
            "prix" => "required",
        ]);

        $panier = Panier::where("client_id", $validated['client_id'])->where("plat_id", $validated["plat_id"])->where("status", false)->first();
        if ($panier && $panier->status == 0) {
            $panier->prix += $validated["prix"];
            $panier->qte += $validated["qte"];
            $panier->save();
            return ApiResponse::success(code: 201);
        } else {
            $panier = Panier::create(
                [
                    "prix" => $validated["prix"],
                    "client_id" => $validated["client_id"],
                    "plat_id" => $validated["plat_id"],
                    "qte" => $validated["qte"],

                ]
            );
            ApiResponse::success(code: 201);
        }


        return ApiResponse::error();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $panier_before = Panier::where("client_id", $id)->where("status", false)->with("plats")->get();
        $paniers = [];
        foreach ($panier_before as $panier) {
            $plat = $panier->plats;
            $url = Storage::disk('public')->url($plat->photo);
            if (strpos($url, 'http://localhost') !== false) {
                $url = str_replace('http://localhost', 'http://localhost:8000', $url); // Remplacez par le port approprié
            }
            $paniers[] = [
                "id" => $panier->id,
                "client_id" => $panier->client_id,
                "status" => $panier->status,
                "prix" => $panier->prix,
                "qte" => $panier->qte,
                "created_at" => $panier->created_at,
                "plat" => $plat->toArray(),

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
