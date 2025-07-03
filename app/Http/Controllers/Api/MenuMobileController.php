<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
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
        $menus = Menu::where('status', true)->with('plats')->orderBy('created_at', "desc")->get();
        return ApiResponse::success(data:MenuResource::collection($menus));
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
            $plats = $plats_before->map(fn($val) => $val->toArray());
        }

            $url_menu = Storage::disk('public')->url($menu->photo);
            if (strpos($url_menu, 'http://localhost') !== false) {
                $url_menu = str_replace('http://localhost', $this->url, $url_menu); // Remplacez par le port approprié
            }
            $data = [
                "id" => $menu->id,
                "nom" => $menu->nom,
                "details" => $menu->details,
                "photo" => $menu->toArray()['photo'],
                "created_at" => $menu->created_at,
                "nbre_plats" => $menu->plats->count(),
                "plats" => $plats
            ];
            
                return response()->json($data, 200);
     
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
