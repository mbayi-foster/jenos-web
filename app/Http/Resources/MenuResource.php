<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $plats=[];
        foreach ($this->plats as $item) {
            $plats[]=[
                'id'=> $item->id,
                'nom'=> $item->nom,
                'photo'=> $item->photo,
            ];
        }
        return [
            'id'=>$this->id,
            'nom'=>$this->nom,
            'status'=>$this->status,
            'createdAt'=>$this->created_at,
            'details'=>$this->details,
            'photo'=>$this->photo,
            'count'=>$this->plats->count(),
            'plats'=>$plats
        ];
    }
}
