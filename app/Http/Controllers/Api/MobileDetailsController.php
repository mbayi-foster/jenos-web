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
        
        return response()->json($plat->toArray(), 200);
    }

    public function plat_menu($id){

    }
}
