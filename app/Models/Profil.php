<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $fillable = [
        "nom",
        "prenom",
        "adresse",
        "commune",
        "status",
        "longitude",
        "latitude",
        "user_id",
        "phone"
    ];

    public function user(){
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
