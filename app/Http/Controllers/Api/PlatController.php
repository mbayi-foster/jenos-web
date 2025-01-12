<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plat;
use Illuminate\Http\Request;

class PlatController extends Controller
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
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plat = Plat::find($id);
        return response()->json([
            "id" => $plat->id,
            "nom" => $plat->nom,
            "prix" => $plat->prix,
            "photo" => $plat->photo,
            "details" => $plat->details,
            "status" => $plat->status,
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
        //
    }

    public function change_status(string $id){
        $plat = Plat::find($id);

        if ($plat->status == true) {
            $plat->status = false;
        } else {
            $plat->status = true;
        }

        $plat->save();
        return response()->json($plat);
    }
}
