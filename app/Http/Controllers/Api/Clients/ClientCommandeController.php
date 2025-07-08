<?php

namespace App\Http\Controllers\Api\Clients;

use App\Enum\FactureStatus;
use App\Enum\LivraisonStatus;
use App\Enum\OrderStatus;
use App\Enum\PanierStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommandeResource;
use App\Models\Commande;
use App\Models\Commune;
use App\Models\Livreur;
use App\Models\Notification;
use App\Models\Panier;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;

class ClientCommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                "prix" => "required|numeric",
                "deliveryCoast" => "required|numeric",
                "paiementMode" => "required|in:cash,vodacome,airtel,orange,africell,visa",
                "facture" => "required|boolean",
                'paniers' => 'required|array',
                'paniers.*' => 'exists:paniers,id',
                'adresse' => 'required',
                'commune' => 'required|exists:communes,id',
                'zone' => 'required|exists:zones,id',
                'clientId' => 'required|exists:users,id',
                'latitude' => 'numeric',
                'longitude' => 'numeric',
                'note' => 'string'
            ]
        );

        $commune = Commune::findOrFail($validated['commune']);
        $zone = Zone::findOrFail($validated['zone']);
        $livreur = Livreur::where('zone_id', $validated['zone'])->withCount([
            'commandes as pending_count' => function ($query) {
                $query->where('status', OrderStatus::PENDING);
            }
        ])
            ->orderBy('pending_count', 'asc')
            ->first();
        $commande = Commande::create([
            "prix" => $validated["prix"],
            "note" => $validated["note"] ?? null,
            "facture" => $validated['facture'] ? FactureStatus::PAID : FactureStatus::PENDING,
            "paiement_mode" => $validated['paiementMode'],
            "ticket" => Commande::generateOrderTicketCode(),
            "adresse" => $validated['adresse'],
            "commune_id" => $commune->id,
            "latitude" => $validated['latitude'] ?? 0,
            "longitude" => $validated['longitude'] ?? 0,
            "client_id" => $validated['clientId'],
            "status" => OrderStatus::PENDING,
            "zone_id" => $zone->id,
            "delivery_coast" => $validated['deliveryCoast'],
            "livreur_id" => $livreur->id ?? null,
        ]);
        if ($commande) {
            foreach ($validated["paniers"] as $panier_id) {
                $panier = Panier::find($panier_id);
                if ($panier) {
                    $panier->status = PanierStatus::COMMANDED;
                    $panier->commande_id = $commande->id;
                    $panier->save();
                }
            }
            Notification::create([
                'label' => 'Nouvelle commande',
                'user_id' => $validated['clientId'],
                'message' => "Nous avons bien reçu votre commande veillez patientez le temps du traitement et de la livraison! \nMerci d'utiliser nos services"
            ]);
            if ($livreur) {
                Notification::create(attributes: [
                    'user_id' => $livreur->user_id,
                    'label' => 'Nouvelle commande',
                    'message' => "Une nouvelle commande vous a été assigné veillez verifier votre dashboard"
                ]);
            }
            return ApiResponse::success(code: 201);
        }
        return ApiResponse::error();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $commande = Commande::findOrFail($id);
        return ApiResponse::success(data: new CommandeResource($commande));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function mesCommandes(string $id)
    {
        $commandes = Commande::where('client_id', $id)->get();
        return ApiResponse::success(data: CommandeResource::collection($commandes));
    }

    public function positionLivreur(string $id)
    {
        $livreur = Livreur::findOrFail($id);
        return ApiResponse::success(data: [
            "adresse" => $livreur->adresse,
            "latitude" => $livreur->latitude,
            "longitude" => $livreur->longitude,
            "commune" => $livreur->commune
        ]);
    }
}
