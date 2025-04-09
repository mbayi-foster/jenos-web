<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Livreur extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'phone',
        'photo',
        'status',
        'busy',
        'adresse',
        'location_lat',
        'location_lon',
        'zone_id'
    ];

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
            "busy"=>$this->busy,
            'adresse' => [
                'lat' => $this->location_lat,
                'lon' => $this->location_lon
            ]
        ];
    }
}
