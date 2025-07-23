<?php

namespace App\Models;

use App\Enum\FactureStatus;
use App\Enum\OrderStatus;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        "ticket",
        "prix",
        "status",
        "adresse",
        'commune_id',
        "latitude",
        "longitude",
        "facture",
        "livreur_id",
        "client_id",
        "zone_id",
        "note",
        "delivery_coast",
        "commune",
        "paiement_mode",
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'facture' => FactureStatus::class
    ];

    public function paniers()
    {
        return $this->hasMany(Panier::class, 'commande_id', 'id');
    }


    public function livreur()
    {
        return $this->belongsTo(Livreur::class, "livreur_id", "id");
    }

    public function client()
    {
        return $this->belongsTo(User::class, "client_id", "id");
    }

    static function generateOrderTicketCode(): string
    {
        $date = new \DateTime();
        $datePart = $date->format('d-m-y');
        $randomPart = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        return "ORDER-{$datePart}-{$randomPart}";
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id');
    }

    public function rapports()
    {
        return $this->hasMany(Rapport::class, 'commande_id', 'id');
    }
}
