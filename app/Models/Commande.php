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
        "delivery_coast"
    ];
}
