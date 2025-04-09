<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Zone extends Model
{
    //
    protected $fillable = [
        'nom',
        'status',
        'chef',
        'lat_max',
        'lat_min',
        'lon_max',
        'lon_min',
    ];

    public function chefs(){
        return $this->belongsTo(User::class, 'chef');
    }

    public function livreurs(){
        return $this->belongsToMany(Livreur::class, "zone_id", "livreur_id");
    }

    public function toArray(){
        return [
            "id"=>$this->id,
            "nom"=>$this->nom,
            "chef"=>$this->chef->toArray(),
            "lat_max"=>$this->lat_max,
            "lat_min"=>$this->lat_min,
            "lon_max"=>$this->lon_max,
            "lon_min"=>$this->lon_min,
            "created_at"=>$this->created_at
        ];
    }
}
