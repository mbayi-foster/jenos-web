<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MobileHomeController extends Controller
{
    public function home(){
        $offres = [];
        $plat_recents = [];
        $plat_pops = [];
        $plat_most_pops = [];

        $res = [
            'offres'=>$offres,
            "plat_recents"=>$plat_recents,
            "plat_pops"=>$plat_pops,
            "plat_most_pops"=>$plat_most_pops
        ];
        return response()->json($res, 200);
    }
}
