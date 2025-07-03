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
        'user_id',
    ];

    public function chefs(){
        return $this->belongsTo(User::class, "user_id", "id" );
    }

    public function livreurs(){
        return $this->hasMany(Livreur::class, "zone_id");
    }

    public function communes(){
        return $this->hasMany(Commune::class);
    }
    

    // public function toArray(){
    //     return [
    //         "id"=>$this->id,
    //         "nom"=>$this->nom,
    //         "status"=>$this->status,
    //         "chef"=>$this->chefs->nom. " ". $this->chefs->prenom,
    //         "created_at"=>$this->created_at,
    //         "count_commune"=>$this->communes->count(),
    //         "communes"=>$this->communes
    //     ];
    // }
}
