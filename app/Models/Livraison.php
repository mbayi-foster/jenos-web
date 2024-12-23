<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    //
    protected $fillable = [];

    public function commande(){
        return $this->belongsTo(Commande::class);
    }

    public function message(){
        return $this->hasMany(Message::class);
    }

    public function livreur(){
        return $this->belongsTo(User::class);
    }
}
