<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class Livreur extends Model
{
    use HasApiTokens;
    protected $fillable = [
        'nom',
        'prenom',
        'user_id',
        'phone',
        'photo',
        'status',
        'busy',
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
    public function toArray()
    {
        $url = Storage::disk('public')->url($this->photo);
        if (strpos($url, 'http://localhost') !== false) {
            $url = str_replace('http://localhost', 'http://localhost:8000', $url);
        }

        return [
            "id" => $this->id,
            "uid" => $this->user_id,
            "nom" => $this->nom,
            "prenom" => $this->prenom,
            "email" => $this->users->email,

            "created_at" => $this->created_at,
            "photo" => $this->photo,
            "phone" => $this->phone,
            "status" => $this->status,
            "busy" => $this->busy,
            'adresse' => [
                'adresse' => $this->adresse,
                'commune' => $this->commune,
                'lat' => $this->location_lat,
                'lon' => $this->location_lon
            ]
        ];
    }
}
