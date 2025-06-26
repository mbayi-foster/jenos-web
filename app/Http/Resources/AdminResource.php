<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $roles = [];
        foreach ($this->roles as $value) {
            $roles[] = $value->nom;
        }
        return [
            "id" => $this->id,
            "email" => $this->email,
            "nom" => $this->profile->nom,
            "prenom" => $this->profile->prenom,
            "phone" => $this->profile->phone,
            "adresse" => $this->profile->adresse,
            "commune" => $this->profile->commune,
            "latitude" => $this->profile->latitude,
            "longitude" => $this->profile->longitude,
            "status" => $this->status,
            "type" => $this->type,
            "roles" => $roles,
            "createdAt" => $this->created_at,

        ];
    }
}
