<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $plat_recents_before = Plat::where('status', true)->orderBy('created_at', 'desc')->take(5)->get();
        $plat_recents = $plat_recents_before->map(fn($plat) => $plat->toArray());

        /* plats populaires */
        $plat_pops = Plat::withCount('paniers') // Assurez-vous que la relation 'paniers' est définie dans le modèle Plat
            ->orderBy('paniers_count', 'desc')
            ->limit(5)
            ->get();
        $plats_pas_chers = Plat::where('status', true)->orderBy('prix', 'asc')->take(5)->get();
        $plat_most_pops = $plats_pas_chers->map(fn($plat) => $plat->toArray());

        $menus = Menu::where("status", true)->orderBy('created_at', 'asc')->take(5)->get();
        $res = [
            "plat_recents" => $plat_recents,
            "plat_pops" => $plat_pops,
            "plat_most_pops" => $plat_most_pops,
            "menus"=>$menus
        ];
        return response()->json($res, 200);
    }

    public function menu()
    {
        $menus = [];
        $menu_befores = Menu::where('status', true)->orderBy('created_at', "desc")->get();
        $menus = $menu_befores->map(fn($val) => $val->toArray());

        return response()->json($menus, 200);
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
