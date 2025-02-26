<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobileDetailsController extends Controller
{
    private $url = "http://localhost:8000";

    public function plat($id)
    {
        $plat = Plat::find($id);
        $url = Storage::disk('public')->url($plat->photo);
        if (strpos($url, 'http://localhost') !== false) {
            $url = str_replace('http://localhost', $this->url, $url); // Remplacez par le port approprié
        }

        $plat = [
            "id"=>$plat->id,
            'nom'=>$plat->nom,
            'details'=>$plat->details,
            'photo'=>$url,
            'qte'=>$plat->qte,
            'prix'=>$plat->prix,
        ];
        return response()->json($plat, 200);
    }
}
