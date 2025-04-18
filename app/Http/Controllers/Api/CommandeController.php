<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Panier;
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
                "prix" => "required|numeric",
                "paiement" => "required|in:cash,carte,bank,mobile,paypal",
                "facture" => "required|bool",
                'paniers' => 'required|array',
                'paniers.*' => 'exists:paniers,id',
                'adresse' => 'require|array',
                'client_id' => 'required|exists:clients,id'
            ]
        );

        // Générer un préfixe de 10 caractères aléatoires
        $prefix = '';
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        for ($i = 0; $i < 6; $i++) {
            $prefix .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        // Obtenir la date actuelle
        $aujourdhui = new DateTime();
        $jour = $aujourdhui->format('d');
        $mois = $aujourdhui->format('m');
        $annee = $aujourdhui->format('y');

        // Créer le ticket
        $ticket = "$jour-$mois-$annee-$prefix";

        // Convertir en majuscules (bien que ce soit déjà le cas)
        $ticket = strtoupper($ticket);

        $commande = Commande::create([
            "prix" => $validated["prix"],
            "facture" => $validated['facture'],
            "paiement" => $validated['paiement'],
            "ticket" => $ticket,
            "mois" => "$mois-$annee",
            "adresse" => $validated['adresse']['adresse'],
            "location_lat" => $validated['adresse']['lat'],
            "location_lon" => $validated['adresse']['lon'],
            "client_id" => $validated['client_id']
        ]);

        if ($commande) {
            foreach ($validated["paniers"] as $panier_id) {
                $panier = Panier::find($panier_id);
                if ($panier) {
                    $panier->status = true;
                    $panier->save();
                }
            }
            $commande->paniers()->attach($validated['paniers']);
            return response()->json(true, 201);
        }

        return response()->json(false, 500);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
