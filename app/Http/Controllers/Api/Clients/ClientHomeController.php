<?php

namespace App\Http\Controllers\Api\Clients;

use App\Enum\PanierStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Http\Resources\PlatResource;
use App\Models\Menu;
use App\Models\Panier;
use App\Models\Plat;
use Illuminate\Http\Request;

class ClientHomeController extends Controller
{
    public function homePage()
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

    public function menusPage()
    {
        $menus = Menu::where('status', true)->with('plats')->orderBy('created_at', "desc")->get();
        return ApiResponse::success(data: MenuResource::collection($menus));
    }

    public function platById(string $id)
    {
        $plat = Plat::findOrFail($id);
        if (!$plat)
            return ApiResponse::error();

        return ApiResponse::success(data: new PlatResource($plat));
    }

    public function addInPanier(Request $request)
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

    public function menuById(string $id)
    {
        $menu = Menu::findOrFail($id);
        return ApiResponse::success(data: new MenuResource($menu));
    }

    public function searchPlats(string $mot)
    {
        // $request->validate([
        //     "order" => 'string'
        // ]);
        $plats = Plat::where("status", true)->where('nom', 'LIKE', "%$mot%")->get();
        return ApiResponse::success(PlatResource::collection($plats));
    }

    public function allPlats()
    {
        $plats = Plat::where('status', true)->inRandomOrder()->get();
        return ApiResponse::success(PlatResource::collection($plats));
    }

}
