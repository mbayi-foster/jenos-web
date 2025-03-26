<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Panier;
use Illuminate\Http\Request;

class PanierController extends Controller
{
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
        } else if(!$panier) {
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

        foreach ($panier_before as $panier) {
            $panier[]= [
                
            ];
        }
        return response()->json($panier_before, 200);
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
    public function destroy(String $id)
    {
        $panier = Panier::where("id", $id)->first();

        if($panier){
            $panier->delete();
            return response()->json(true, 200);
        }else{
            return response()->json(false, 500);
        }
    }
}
