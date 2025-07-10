<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommuneResource;
use App\Models\Commune;
use Illuminate\Http\Request;

class CommuneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $communes = Commune::orderBy("nom", "asc")->get();
        return ApiResponse::success(CommuneResource::collection($communes));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "nom" => "required",
            "zone" => "required|exists:zones,id",
            "frais" => 'required'
        ]);

        $commune = Commune::create(
            [
                "nom" => $validated['nom'],
                "zone_id" => $validated["zone"],
                "frais" => $validated['frais'],
                "status"=>true,
            ]
        );
        return ApiResponse::success(new CommuneResource($commune));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $commune = Commune::find($id);
        if ($commune) {
            $commune->delete();
        }
        return response()->json('supprimé', 200);

    }
}
