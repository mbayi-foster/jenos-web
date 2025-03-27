<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Commande;
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
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                "prix"=>"required|numeric",
                'paniers' => 'required|array', // Assurez-vous que 'roles' est un tableau
                'paniers.*' => 'exists:paniers,id',
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
            "prix"=>$validated["prix"],
            "ticket" => $ticket,
            "mois"=>"$mois-$annee",
            "client_id" => $validated['client_id']
        ]);

        if ($commande) {
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
