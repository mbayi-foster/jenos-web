<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class Livreur extends Model
{
    use HasApiTokens;
    protected $fillable = [
        'user_id',
        'adresse',
        'commune',
        'location_lat',
        'location_lon',
        'zone_id'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

     public function commandes()
    {
        return $this->hasMany(Commande::class, 'livreur_id', 'id');
    }

    public function zone(){
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }
 
}
