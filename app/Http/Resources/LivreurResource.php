<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LivreurResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $profile = $this->profile;
        $livreur = $this->livreur;
        return
            [
                "id" => $this->id,
                "nom" => $profile->nom,
                "prenom" => $profile->prenom,
                "phone" => $profile->phone,
                "email" => $this->email,
                "status" => $this->status,
                "adresse" => $livreur->adresse,
                "commune" => $livreur->commune,
                "latitude" => $livreur->latitude,
                "longitude" => $livreur->longitude,
                "zone" => $livreur->zone->nom,
                "zoneId" => $livreur->zone->id,
                "createdAt" => $this->created_at,
                "updatedAt" => $this->updated_at,

            ];
    }
}
