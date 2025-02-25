<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'nom', 'prenom', 'email', 'password', 'phone', 'photo', 'status'
    ];

    public function paniers(){
        return $this->hasMany(Panier::class);
    }
}
