<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menu = Menu::withCount('plats')->get();
        $nouveauMenu = $menu->map(fn($val)=>$val->toArray());
        // foreach ($menu as $value) {
        //     $url = Storage::disk('public')->url($value->photo);
        //     if (strpos($url, 'http://localhost') !== false) {
        //         $url = str_replace('http://localhost', 'http://localhost:8000', $url); // Remplacez par le port approprié
        //     }
        //     $nouveauMenu[] = [
        //         "id"=>$value->id,
        //         "nom" => $value->nom,
        //         'count' => $value->plats_count,
        //         'photo'=> $url,
        //         'status'=> $value->status
        //     ];
        // }

        return response()->json($nouveauMenu);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nom" => "required",
            "plats" => "required",
            "photo" => "required|image"
        ]);

        if ($request->file('photo')) {

            $timestamp = time();
            $newName = $request->nom . '_' . $timestamp . '.' . $request->file('photo')->getClientOriginalExtension();
            $path = $request->file('photo')->storeAs('images/menus', $newName, 'public');
            $menu = Menu::create([
                "nom" => $request->nom,
                "photo" => $path
            ]);
            $platIds = explode(',', $request->plats);

            $menu->plats()->attach($platIds);
            return response()->json(true, 201);
        } else {
            return response()->json(['error' => 'Aucune photo téléchargée.'], 400);
        }



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
        $menu = Menu::findOrFail($id);
        if($menu){
            $menu->delete();
            return response()->json(true,200);
        }
        return response()->json(false,400);
    }


    public function change_status(string $id)
    {
        $menu = Menu::find($id);

        $menu->status = ($menu->status == true) ? false : true ;

        $menu->save();
        return response()->json(true, 200);
    }

}
