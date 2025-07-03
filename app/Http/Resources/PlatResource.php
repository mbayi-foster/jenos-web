<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $date = new DateTime($this->created_at);
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'prix' => $this->prix,
            'status' => $this->status,
            'commandes' => $this->commandes,
            'createdAt' => $this->created_at,
            'details' => $this->details,
            'photo' => $this->photo,
            'like' => $this->like,
            'date' => strftime('%A, %d %B %Y à %Hh%M', $date->getTimestamp())
        ];

        /* 
        "id": 3,
      "nom": "Mango",
      "details": "delices",
      "photo": "https://jenos-food.s3.amazonaws.com/plats/685e7e1caae55_mango.jpg",
      "status": 1,
      "prix": 6500,
      "commandes": 0,
      "like": 0,
      "created_at": "2025-06-27T11:18:57.000000Z",
      "date": "Friday, 27 June 2025 à 11h18" */
    }
}

