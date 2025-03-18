<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobileDetailsController extends Controller
{

    private $photo = "https://cdn.pixabay.com/photo/2024/09/15/13/03/cows-9049119_1280.jpg";
    private $url;

    public function __construct()
    {
        $this->url = env("APP_URL");
    }
    public function plat($id)
    {
        $plat = Plat::find($id);
        $url = Storage::disk('public')->url($plat->photo);
        if (strpos($url, 'http://localhost') !== false) {
            $url = str_replace('http://localhost', $this->url.":8000", $url); // Remplacez par le port approprié
        }

        $plat = [
            "id" => $plat->id,
            'nom' => $plat->nom,
            'details' => $plat->details,
            "like" => $plat->like,
            'photo' => $this->photo,
            'qte' => $plat->qte,
            'prix' => $plat->prix,
            'created_at' => $plat->created_at
        ];
        return response()->json($plat, 200);
    }

    public function plat_menu($id){

    }
}
