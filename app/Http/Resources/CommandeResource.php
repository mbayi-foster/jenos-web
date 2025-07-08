<?php

namespace App\Http\Resources;

use App\Enum\FactureStatus;
use App\Models\Commune;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommandeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $livreur = $this->livreur_id != null ? $this->livreur->user->profile : null;

        return [
            "id" => $this->id,
            "ticket" => $this->ticket,
            "status" => $this->status,
            "note" => $this->note,
            "prix" => $this->prix,
            "deliveryCoast" => $this->delivery_coast,
            "adresse" => [
                "adresse" => $this->adresse,
                "latitude" => $this->latitude,
                "longitude" => $this->longitude,
                "commune" => Commune::findOrFail($this->commune_id)->nom
            ],
            "paiementMode" => $this->paiement_mode,
            "facture" => $this->facture == FactureStatus::PAID ? true : false,
            "livreur" => $livreur != null ? [
                "id" => $this->livreur_id,
                "nom" => $livreur->nom,
                "prenom" => $livreur->prenom,
                "phone" => $livreur->phone
            ] : null,
            "createdAt" => $this->created_at,
        ];
    }
}
