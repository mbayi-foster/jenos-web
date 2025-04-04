<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'phone',
        'photo',
        'status',
        'adresse',
        'location_lat',
        'location_lon'
    ];

    public function paniers()
    {
        return $this->hasMany(Panier::class);
    }
}
