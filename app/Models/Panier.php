<?php

namespace App\Models;

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

    public function clients()
    {
        return $this->belongsTo(Client::class);
    }

    public function plats()
    {
        return $this->belongsTo(Plat::class, "plat_id");
    }
}
