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
        "lat",
        "long",
        "facture",
        "mois",
        "livreur",
        "client_id",
        "zone_id",
        "livraison",
        "confirm",
        "note",
        "classer"
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }


    public function paniers()
    {
        return $this->belongsToMany(Panier::class, "commande_panier");
    }

    public function livreur()
    {
        return $this->belongsTo(Livreur::class, 'livreur');
    }
}
