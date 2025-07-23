<?php

namespace App\Http\Controllers\Api;

use App\Enum\OrderStatus;
use App\Enum\PanierStatus;
use App\FactureStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommandeResource;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Livreur;
use App\Models\Commune;
use App\Models\Notification;
use App\Models\Panier;
use Illuminate\Http\Request;
use DateTime;

class CommandeController extends Controller
{


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $commande = Commande::where('id', $id)->with('paniers')->first();
        return ApiResponse::success(data: new CommandeResource($commande), message: 'Commande trouvée');
    }


    public function commandes_gerant($id)
    {
        $commandesDb = Commande::findOrFail($id);
        return response()->json($commandesDb->toArray(), 200);
    }
    public function commandes_gerant_by_zone($id)
    {
        $commandesDb = Commande::where('zone_id', $id)->orderBy("created_at", "desc")->get();
        $commandes = $commandesDb->map(fn($commande) => $commande->toArray());
        return response()->json($commandes, 200);
    }

    public function valider_commande(Request $request, string $id)
    {
        $validated = $request->validate([
            'livreur_id' => 'required|exists:livreurs,id',
        ]);
        $commande = Commande::findOrFail($id);
        $commande->status = true;
        $commande->confirm = true;
        $commande->livreur_id = $request->livreur_id;
        $commande->save();

        return response()->json(true, 200);
    }

    public function commandes(string $zone)
    {
        $commandes = Commande::where('zone_id', $zone)->orderBy("created_at", "desc")->get();
        return ApiResponse::success(data: CommandeResource::collection($commandes));
    }
}
