<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    protected $fillable = [
        "nom",
        "status",
        "zone_id",
        'frais'
    ];

    public function zone(){
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function toArray(){
        return [
            'id'=>$this->id,
            'nom'=>$this->nom,
            'zone'=>$this->zone->nom,
            'zone_id'=>$this->zone->id,
            'frais'=>$this->frais,
        ];
    }
}
