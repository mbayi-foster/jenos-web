<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Plat;

class MobileHomeController extends Controller
{
    public function home()
    {
        $offres = [];
        $plat_recents = [];
        $plat_pops = [];
        $plat_most_pops = [];
        $plat_recents_before = Plat::where('status', true)->orderBy('created_at', 'desc')->take(5)->get();
        $plat_pops_before = Plat::where('status', true)->orderBy('like', 'desc')->take(5)->get();
        $plat_most_pops_before = Plat::where('status', true)->orderBy('like', 'desc')->take(5)->get();

        foreach ($plat_recents_before as $plat) {
            $url = Storage::disk('public')->url($plat->photo);
            if (strpos($url, 'http://localhost') !== false) {
                $url = str_replace('http://localhost', 'http://localhost:8000', $url); // Remplacez par le port approprié
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

        foreach ($plat_most_pops_before as $plat) {
            $url = Storage::disk('public')->url($plat->photo);
            if (strpos($url, 'http://localhost') !== false) {
                $url = str_replace('http://localhost', 'http://localhost:8000', $url); // Remplacez par le port approprié
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
        foreach ($plat_pops_before as $plat) {
            $url = Storage::disk('public')->url($plat->photo);
            if (strpos($url, 'http://localhost') !== false) {
                $url = str_replace('http://localhost', 'http://localhost:8000', $url); // Remplacez par le port approprié
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

        $res = [
            'offres' => $offres,
            "plat_recents" => $plat_recents,
            "plat_pops" => $plat_pops,
            "plat_most_pops" => $plat_most_pops
        ];
        return response()->json($res, 200);
    }
}
