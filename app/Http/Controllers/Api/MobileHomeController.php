<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Plat;

class MobileHomeController extends Controller
{
    private $photo = "https://cdn.pixabay.com/photo/2024/09/15/13/03/cows-9049119_1280.jpg";
    private $url;

    public function __construct()
    {
        $this->url = env("APP_URL");
    }
    public function home()
    {
        /* les plats reçents */
        $plat_recents_before = Plat::where('status', true)->orderBy('created_at', 'desc')->take(5)->get();
        $plat_recents = $plat_recents_before->map(fn($plat) => $plat->toArray());

        /* plats populaires */
        $plat_pops_before = Plat::where('status', true)->orderBy('like', 'desc')->take(5)->get();
        $plat_pops = $plat_pops_before->map(fn($plat) => $plat->toArray());

        /* plats très populaire */
        $plat_most_pops_before = Plat::where('status', true)->orderBy('like', 'desc')->orderBy('commandes', 'desc')->take(5)->get();
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

        foreach ($menu_befores as $menu) {
            $url = Storage::disk('public')->url($menu->photo);
            if (strpos($url, 'http://localhost') !== false) {
                $url = str_replace('http://localhost', $this->url, $url); // Remplacez par le port approprié
            }
            $menus[] = [
                "id" => $menu->id,
                "nom" => $menu->nom,
                "details" => $menu->details,
                "photo" => $url,
                "created_at" => $menu->created_at
            ];
        }

        return response()->json($menus, 200);
    }

    public function plats_recents()
    {
        $plat_recents = [];
        $plat_recents_before = Plat::where('status', true)->orderBy('created_at', 'desc')->take(5)->get();

        foreach ($plat_recents_before as $plat) {
            $url = Storage::disk('public')->url($plat->photo);
            if (strpos($url, 'http://localhost') !== false) {
                $url = str_replace('http://localhost', $this->url, $url); // Remplacez par le port approprié
            }
            $plat_recents[] = [
                'id' => (int) $plat->id,
                'nom' => $plat->nom,
                'details' => $plat->details,
                'photo' => $url,
                'prix' => $plat->prix,
                'like' => $plat->like,
                'created_at' => $plat->created_at
            ];
        }

        return response()->json($plat_recents, 200);
    }
    public function plats_pops()
    {
        $plat_pops = [];
        $plat_pops_before = Plat::where('status', true)->orderBy('like', 'desc')->get();

        foreach ($plat_pops_before as $plat) {
            $url = Storage::disk('public')->url($plat->photo);
            if (strpos($url, 'http://localhost') !== false) {
                $url = str_replace('http://localhost', $this->url, $url); // Remplacez par le port approprié
            }
            $plat_pops[] = [
                'id' => (int) $plat->id,
                'nom' => $plat->nom,
                'details' => $plat->details,
                'photo' => $url,
                'prix' => $plat->prix,
                'like' => $plat->like,
                'created_at' => $plat->created_at
            ];
        }

        return response()->json($plat_pops, 200);
    }
    public function plats_most_pops()
    {
        $plat_most_pops = [];
        $plat_most_pops_before = Plat::where('status', true)->orderBy('like', 'desc')->get();

        foreach ($plat_most_pops_before as $plat) {
            $url = Storage::disk('public')->url($plat->photo);
            if (strpos($url, 'http://localhost') !== false) {
                $url = str_replace('http://localhost', $this->url, $url); // Remplacez par le port approprié
            }
            $plat_most_pops[] = [
                'id' => (int) $plat->id,
                'nom' => $plat->nom,
                'details' => $plat->details,
                'photo' => $url,
                'prix' => $plat->prix,
                'like' => $plat->like,
                'created_at' => $plat->created_at
            ];
        }

        return response()->json($plat_most_pops, 200);
    }

    public function plats_by_menu($id)
    {
        $plats = [];
        $plat_by_menu = Menu::where('id', $id)->with([
            'plats' => function ($query) {
                $query->where('status', true);
            }
        ])

            ->where('status', true)
            ->first();

        $plats = $plat_by_menu->map(fn($plat) => $plat->toArray());

        return response()->json($plats, 200);
    }
}
