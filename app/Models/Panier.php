<?php

namespace App\Models;

use App\Enum\PanierStatus;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    protected $fillable = [
        "nom",
        "client_id",
        "plat_id",
        "qte",
        "commander",
        "prix",
        'status',
        "commande_id",
    ];

    protected $casts = [
        'status' => PanierStatus::class
    ];

    public function clients()
    {
        return $this->belongsTo(Client::class);
    }

    public function plat()
    {
        return $this->belongsTo(Plat::class, "plat_id");
    }

    public function toArray()
    {
        return [
            "id" => $this->id,
            "client_id" => $this->client_id,
            "status" => $this->status,
            "prix" => $this->prix,
            "qte" => $this->qte,
            "created_at" => $this->created_at,
            "plat" => $this->plat,
        ];
    }
}
