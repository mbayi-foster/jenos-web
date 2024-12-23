<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [];

    public function client(){
        return $this->belongsTo(User::class, 'client_id');
    }

    public function livraison(){
        return $this->hasOne(Livraison::class);
    }

    public function plat(){
        return $this->belongsToMany(Plat::class, 'commande_plat');
    }
}
