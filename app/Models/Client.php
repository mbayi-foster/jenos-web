<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Client extends Model
{
    use HasApiTokens;
    protected $fillable = [
        'nom',
        'prenom',
        'user_id',
        'phone',
        'photo',
        'status',
        'adresse',
        'commune',
        'location_lat',
        'location_lon',
    ];

    public function paniers()
    {
        return $this->hasMany(Panier::class);
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
   
    public function toArray()
    {
        $url = Storage::disk('public')->url($this->photo);
        if (strpos($url, 'http://localhost') !== false) {
            $url = str_replace('http://localhost', 'http://localhost:8000', $url);
        }

        return [
            "id" => $this->id,
            "uid"=>$this->user_id,
            "nom" => $this->nom,
            "prenom" => $this->prenom,
            "email" => $this->users->email,
            "created_at" => $this->created_at,
            "photo" => $this->photo,
            "phone" => $this->phone,
            "status" => $this->status,
            'adresse' => [
                'adresse' => $this->adresse,
                'commune' => $this->commune,
                'lat' => $this->location_lat,
                'lon' => $this->location_lon
            ]
        ];
    }
}
