<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        "ticket",
        "prix",
        "status",
        "adresse",
        'commune_id',
        "location_lat",
        "location_lon",
        "facture",
        "livreur_id",
        "client_id",
        "zone_id",
        "confirm",
        "note",
        "delivery_coast",
        "commune"
    ];

    public function paniers()
    {
        return $this->hasMany(Panier::class, 'commande_id', 'id');
    }

    public function livreur()
    {
        return $this->belongsTo(Livreur::class, "livreur_id", "id");
    }
    public function toArray()
    {
        return [
            "id" => $this->id,
            "ticket" => $this->ticket,
            "prix" => $this->prix,
            "delivery_coast" => $this->delivery_coast,
            "status" => $this->status,
            "confirm" => $this->confirm,
            "facture" => $this->facture,
            "livraison" => $this->livraison,
            "paiement" => $this->paiement,
            "adresse" => [
                'adresse' => $this->adresse,
                'commune' => $this->commune,
                'lat' => $this->location_lat,
                'lon' => $this->location_lon
            ],
            "zone" => $this->zone_id,
            "livreur" => $this->livreur != null ? [
                "nom" => $this->livreur->nom,
                "prenom" => $this->livreur->prenom,
                "phone" => $this->livreur->phone
            ] : null,
            "paniers" => $this->paniers,
            "created_at" => $this->created_at
        ];
    }
}
