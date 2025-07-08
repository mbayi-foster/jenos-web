<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PanierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $plat = $this->plat;
        $date = new DateTime($plat->created_at);
        return [
            'id' => $this->id,
            'qte' => $this->qte,
            'prix' => $this->prix,
            'status' => $this->status,
            'plat' => [
                'id' => $plat->id,
                'nom' => $plat->nom,
                'prix' => $plat->prix,
                'status' => $plat->status,
                'commandes' => $plat->commandes,
                'createdAt' => $plat->created_at,
                'details' => $plat->details,
                'photo' => $plat->photo,
                'like' => $plat->like,
                'date' => strftime('%A, %d %B %Y à %Hh%M', $date->getTimestamp())
            ]
        ];
    }
}
