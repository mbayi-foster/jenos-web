<?php

namespace App\Http\Controllers\Api;

use App\FactureStatus;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Livreur;
use App\Models\Commune;
use App\Models\Notification;
use App\Models\Panier;
use App\OrderStatus;
use Illuminate\Http\Request;
use DateTime;

class CommandeController extends Controller
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
     * creation de la commande
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                "prix" => "required",
                "delivery_coast" => "required",
                "paiement" => "required|in:cash,carte,bank,mobile,paypal",
                "facture" => "required|string",
                'paniers' => 'required|array',
                'paniers.*' => 'exists:paniers,id',
                'adresse' => 'required',
                'client_id' => 'required|exists:clients,id'
            ]
        );
        $commune = Commune::whereRaw('LOWER(nom) = ?', [strtolower($validated['adresse']['commune'])])->first();

        // trouver le livreur
        $livreur = Livreur::withCount([
            'commandes as pending_count' => function ($query) {
                $query->where('livraison', 'pending');
            }
        ])
            ->orderBy('pending_count', 'asc')
            ->first();

        $commande = Commande::create([
            "prix" => $validated["prix"],
            "note" => $request->note,
            "facture" => FactureStatus::PENDING,
            "paiement" => $validated['paiement'],
            "ticket" => Commande::generateOrderTicketCode(),
            "adresse" => $validated['adresse']['adresse'],
            "commune" => $validated['adresse']['commune'],
            "location_lat" => $validated['adresse']['lat'],
            "location_lon" => $validated['adresse']['lon'],
            "client_id" => $validated['client_id'],
            "status" => OrderStatus::PENDING,
            "livraison" => $livreur ? "pending" : "null",
            "zone_id" => ($commune != null) ? $commune->zone_id : 1,
            "delivery_coast" => $validated['delivery_coast'],
            "livreur_id" => $livreur ? $livreur->id : null,
        ]);



        if ($commande) {
            foreach ($validated["paniers"] as $panier_id) {
                $panier = Panier::find($panier_id);
                if ($panier) {
                    $panier->status = true;
                    $panier->commande_id = $commande->id;
                    $panier->save();
                }
            }
            $client = Client::find($commande->client_id);

            Notification::create([
                'user_id' => $client->toArray()['uid'],
                'message' => "Nous avons bien reçu votre commande veillez patientez le traitement et la livraison! \nMerci d'utiliser nos services"
            ]);
            if ($livreur)
                Notification::create(attributes: [
                    'user_id' => $livreur->uid,
                    'message' => "Nous avons bien reçu votre commande veillez patientez le traitement et la livraison! \nMerci d'utiliser nos services"
                ]);
            return response()->json(true, 201);
        }
        return response()->json(false, 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $commandesDb = Commande::where('client_id', $id)->orderBy("created_at", "desc")->get();
        $commandes = $commandesDb->map(fn($commande) => $commande->toArray());
        return response()->json($commandes, 200);
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

}
