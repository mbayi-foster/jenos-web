<?php

namespace App\Http\Resources;

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
        return [
            'id'=>$this->id,
            'nom'=>$this->nom,
            'prix'=>$this->prix,
            'status'=>$this->status,
            'commandes'=>$this->commandes,
            'createdAt'=>$this->created_at,
            'details'=>$this->details,
            'photo'=>$this->photo,
        ];
    }
}

