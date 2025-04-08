<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
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

    public function toArray()
    {
        $url = Storage::disk('public')->url($this->photo);
        if (strpos($url, 'http://localhost') !== false) {
            $url = str_replace('http://localhost', 'http://localhost:8000', $url);
        }

        return [
            "nom" => $this->nom,
            "prenom" => $this->prenom,
            "email" => $this->email,
            "id" => $this->id,
            "created_at" => $this->created_at,
            "photo" => $this->photo,
            "phone" => $this->phone,
            "status" => $this->status,
            'adresse' => [
                'adresse' => $this->adresse,
                'lat' => $this->location_lat,
                'lon' => $this->location_lon
            ]
        ];
    }
}
