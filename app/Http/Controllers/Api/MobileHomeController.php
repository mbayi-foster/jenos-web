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
        $plat_pops = DB::select("SELECT p.id, p.nom, p.prix, COUNT(pp.plat_id) AS nombre_ajouts
                                            FROM plats p
                                            JOIN panier_plat pp ON p.id = pp.plat_id
                                            JOIN paniers pa ON pp.panier_id = pa.id
                                            WHERE pa.status = true
                                            GROUP BY p.id, p.nom, p.prix
                                            ORDER BY nombre_ajouts DESC");
        $plat_most_pops_before = Plat::where('status', true)->orderBy('commandes', 'desc')->take(5)->get();
        $plat_most_pops = $plat_most_pops_before->map(fn($plat) => $plat->toArray());

        $res = [
            "plat_recents" => $plat_recents,
            "plat_pops" => $plat_pops,
            "plat_most_pops" => $plat_most_pops
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
