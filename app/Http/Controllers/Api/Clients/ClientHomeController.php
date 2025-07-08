<?php

namespace App\Http\Controllers\Api\Clients;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Http\Resources\PlatResource;
use App\Models\Menu;
use App\Models\Plat;
use Illuminate\Http\Request;

class ClientHomeController extends Controller
{
    public function homePage()
    {
        // /* les plats reçents */
        // $plat_recents = Plat::where('status', true)->orderBy('created_at', 'desc')->take(5)->get();


        // /* plats populaires */
        // $plat_pops = Plat::withCount('paniers')
        //     ->orderBy('paniers_count', 'desc')
        //     ->limit(5)
        //     ->get();
        // $plat_most_pops = Plat::where('status', true)
        //     ->orderBy('prix', 'asc')
        //     ->take(5)
        //     ->get();
        // $menus = Menu::where("status", true)
        //     ->orderBy('created_at', 'asc')
        //     ->take(5)
        //     ->get();
        // $res = [
        //     "plat_recents" => PlatResource::collection($plat_recents),
        //     "plat_pops" => PlatResource::collection($plat_pops),
        //     "plat_most_pops" => PlatResource::collection($plat_most_pops),
        //     "menus" => MenuResource::collection($menus),
        // ];
        // return ApiResponse::success(data: $res);

        return response()->json(['hello']);
    }
}
