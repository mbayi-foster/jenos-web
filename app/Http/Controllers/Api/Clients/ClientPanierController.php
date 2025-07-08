<?php

namespace App\Http\Controllers\Api\Clients;

use App\Enum\PanierStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PanierResource;
use App\Models\Panier;
use Illuminate\Http\Request;

class ClientPanierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "clientId" => "required|exists:users,id",
            "platId" => "required|exists:plats,id,status,1",
            "qte" => "required",
            "prix" => "required",
        ]);

        $panier = Panier::where("client_id", $validated['clientId'])
            ->where("plat_id", $validated["platId"])
            ->where("status", PanierStatus::AVAILLABLE)
            ->first();

        if ($panier != null && $panier->status == PanierStatus::AVAILLABLE) {
            $panier->prix += $validated["prix"];
            $panier->qte += $validated["qte"];
            $panier->save();
            return ApiResponse::success(code: 201, data: $panier);
        }

        $newPanier = Panier::create(
            [
                "prix" => $validated["prix"],
                "client_id" => $validated["clientId"],
                "plat_id" => $validated["platId"],
                "qte" => $validated["qte"],

            ]
        );
        if ($newPanier) {
            return ApiResponse::success(code: 201, data: $newPanier);
        }
        return ApiResponse::error();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paniers = Panier::where('client_id', $id)
            ->where('status', PanierStatus::AVAILLABLE)
            // ->with('plat')
            ->get();
        return ApiResponse::success(data: PanierResource::collection($paniers));
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
        $panier = Panier::findOrFail($id);
        $panier->status = PanierStatus::DELETED;
    }
}
