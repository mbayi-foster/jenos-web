<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuMobileController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $photo = "https://cdn.pixabay.com/photo/2024/09/15/13/03/cows-9049119_1280.jpg";
    private $url;

    public function __construct()
    {
        $this->url = env("APP_URL");
    }


    public function index()
    {
        $menus = [];
        $menu_befores = Menu::where('status', true)->with('plats')->orderBy('created_at', "desc")->get();

        foreach ($menu_befores as $menu) {
            $url = Storage::disk('public')->url($menu->photo);
            if (strpos($url, 'http://localhost') !== false) {
                $url = str_replace('http://localhost', $this->url . ":8000", $url); // Remplacez par le port approprié
            }
            $menus[] = [
                "id" => $menu->id,
                "nom" => $menu->nom,
                "details" => $menu->details,
                "photo" => $url,
                "created_at" => $menu->created_at,
                "nbre_plats" => $menu->plats->count()
            ];
        }

        return response()->json($menus, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $plats = [];
        $menu = Menu::where("id", $id)->where("status", true)->with("plats")->first();

        if ($menu) {
            $plats_before = $menu->plats;
            foreach ($plats_before as $plat) {
                if ($plat->status == true) {
                    $url = Storage::disk('public')->url($plat->photo);
                    if (strpos($url, 'http://localhost') !== false) {
                        $url = str_replace('http://localhost', $this->url, $url); // Remplacez par le port approprié
                    }
                    $plats[] = [
                        'id' => (int) $plat->id,
                        'nom' => $plat->nom,
                        'details' => $plat->details,
                        'photo' => $this->photo,
                        'prix' => $plat->prix,
                        'like' => $plat->like,
                        'created_at' => $plat->created_at
                    ];
                }
            }

            $url_menu = Storage::disk('public')->url($menu->photo);
            if (strpos($url_menu, 'http://localhost') !== false) {
                $url_menu = str_replace('http://localhost', $this->url, $url_menu); // Remplacez par le port approprié
            }
            $data = [
                "id" => $menu->id,
                "nom" => $menu->nom,
                "details" => $menu->details,
                "photo" => $url_menu,
                "created_at" => $menu->created_at,
                "nbre_plats" => $menu->plats->count(),
                "plats" => $plats
            ];
           if(count($plats)>= 1){
            return response()->json($data, 200);
           }
        }

        return response()->json(false, 500);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        //
    }
}
