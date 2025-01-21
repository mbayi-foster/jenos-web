<?php

namespace App\Http\Controllers;

use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plats = Plat::all();
        return view('users.admin.plats', compact('plats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.create-plat');
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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:102400',
        ]);

        // Store the image
        $path = null;
        if ($request->file('photo')) {

            $originalName = $request->file('photo')->getClientOriginalName();
            $timestamp = time(); // Obtenir le timestamp actuel
            $newName = $request->nom . '_' . $timestamp . '.' . $request->file('photo')->getClientOriginalExtension();
            // Uploader l'image avec le nouveau nom
            $path = $request->file('photo')->storeAs('images', $newName, 'public');
        }

        $plat = Plat::create([
            "nom" => $request->nom,
            "prix" => $request->prix,
            "photo" => $path,
            "details" => $request->details
        ]);

        return response()->json($plat);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('users.admin.plat');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
        //
    }
    public function change(Request $request, string $id)
    {
        $plat = Plat::find($id);
        $request->validate([
            'nom' => 'required',
            'prix' => 'required|numeric',
            'details' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:102400',
        ]);

        $path = $plat->photo;
        if ($request->file('photo')) {

            $originalName = $request->file('photo')->getClientOriginalName();
            $timestamp = time(); // Obtenir le timestamp actuel
            $newName = $request->nom . '_' . $timestamp . '.' . $request->file('photo')->getClientOriginalExtension();
            // Uploader l'image avec le nouveau nom
            $path = $request->file('photo')->storeAs('images', $newName, 'public');
            $plat->photo = $path;
        }

        $plat->nom = $request->nom;
        $plat->prix = $request->prix;
        $plat->details = $request->details;

        $plat->save();
        return redirect()->back()->with('success', 'Mis à jour réussie !');
    }
}
