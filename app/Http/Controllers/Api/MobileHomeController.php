<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Http\Resources\PlatResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Plat;
use Illuminate\Support\Facades\DB;

class MobileHomeController extends Controller
{
    public function home()
    {
        /* les plats reçents */
        $plat_recents = Plat::where('status', true)->orderBy('created_at', 'desc')->take(5)->get();


        /* plats populaires */
        $plat_pops = Plat::withCount('paniers')
            ->orderBy('paniers_count', 'desc')
            ->limit(5)
            ->get();
        $plat_most_pops = Plat::where('status', true)
            ->orderBy('prix', 'asc')
            ->take(5)
            ->get();
        $menus = Menu::where("status", true)
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();
        $res = [
            "plat_recents" => PlatResource::collection($plat_recents),
            "plat_pops" => PlatResource::collection($plat_pops),
            "plat_most_pops" => PlatResource::collection($plat_most_pops),
            "menus" => MenuResource::collection($menus),
        ];
        return ApiResponse::success(data: $res);
    }

    public function menu()
    {
        $menus = Menu::where('status', true)
            ->orderBy('created_at', "desc")
            ->get();
        return ApiResponse::success(data: MenuResource::collection($menus));
    }
    public function plats_by_menu($id)
    {
        $plats = [];
        $plat_by_menu = Menu::where('id', $id)
            ->where('status', true)
            ->with([
                'plats' => function ($query) {
                    $query->where('status', true);
                }
            ])
            ->first();
        $plats = $plat_by_menu['plats']->map(fn($plat) => $plat->toArray());
        return response()->json($plats, 200);
    }
}
