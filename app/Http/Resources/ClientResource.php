<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "email" => $this->email,
            "nom" => $this->profile->nom,
            "prenom" => $this->profile->prenom,
            "phone" => $this->profile->phone,
            "adresse" => [
                "adresse" => $this->profile->adresse,
                "commune" => $this->profile->commune,
                "latitude" => $this->profile->latitude,
                "longitude" => $this->profile->longitude,
            ],
            "status" => $this->status,
            "type" => $this->type,
            "createdAt" => $this->created_at,
        ];
    }
}
