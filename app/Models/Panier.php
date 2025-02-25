<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
   protected $fillable = [
        "nom","client_id","plat_id","qte","commander"
    ];

    public function clients(){
        return $this->belongsTo(Client::class);
    }

    public function plats(){
        return $this->belongsTo(Plat::class);
    }
}
