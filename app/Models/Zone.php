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
    ];

    public function chefs(){
        return $this->belongsTo(User::class, "zone_id", "chef");
    }

    public function livreurs(){
        return $this->hasMany(Livreur::class, "zone_id");
    }

    public function communes(){
        return $this->hasMany(Commune::class);
    }
    

    public function toArray(){
        $chef = User::find($this->chef);
        return [
            "id"=>$this->id,
            "nom"=>$this->nom,
            "status"=>$this->status,
            "chef"=>"$chef->prenom $chef->nom",
            "created_at"=>$this->created_at,
            "count_commune"=>$this->communes->count(),
            "communes"=>$this->communes
        ];
    }
}
