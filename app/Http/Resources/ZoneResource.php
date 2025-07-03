<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ZoneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $communes = [];
        foreach ($this->communes as $commune) {
            $communes[] = [
                "id" => $commune->id,
                "nom" => $commune->nom,
                "status"=>$commune->status,
                "frais"=>$commune->frais,
                "zoneId"=>$commune->zone_id,
            ];
        }
        $chef = $this->chefs->profile;
        return [
            "id" => $this->id,
            "nom" => $this->nom,
            "status" => $this->status,
            "chef" => $chef->nom . " " . $chef->prenom,
            "createdAt" => $this->created_at,
            "countCommunes" => $this->communes->count(),
            "communes" => $communes
        ];
    }
}
