<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livreur extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'phone',
        'photo',
        'status',
        'busy',
        'location_lat',
        'location_lon'
    ];

    public function commandes(){
        return $this->hasMany(Commande::class, 'commandes', 'id');
    }
}
