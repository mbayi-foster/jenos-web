<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Livreur;

class CommandeLivreurController extends Controller
{
    public function pending(Request $request, String $id)
    {
        $commandesDb = Commande::where('livreur_id', $id)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $commandesDb,
            'message' => 'Commandes récupérées avec succès',
        ], 200);
    }
}
