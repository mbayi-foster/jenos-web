<?php

namespace App\Http\Resources;

use App\Enum\FactureStatus;
use App\Models\Commune;
use App\Models\Profil;
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
        $client = Profil::where('user_id', $this->client_id)->first();

        $paniers = PanierResource::collection($this->paniers);

        return [
            "id" => $this->id,
            "ticket" => $this->ticket,
            "status" => $this->status,
            "note" => $this->note,
            "prix" => $this->prix,
            "deliveryCoast" => $this->delivery_coast,
            "paiementMode" => $this->paiement_mode,
            "facture" => $this->facture == FactureStatus::PAID ? true : false,
            "livreur" => $livreur != null ? [
                "id" => $this->livreur_id,
                "nom" => $livreur->nom,
                "prenom" => $livreur->prenom,
                "phone" => $livreur->phone
            ] : null,
            "localisation" => [
                "adresse" => $this->adresse,
                "latitude" => $this->latitude,
                "longitude" => $this->longitude,
                "commune" => Commune::findOrFail($this->commune_id)->nom
            ],
            "client" => [
                "id" => $client->user_id,
                "email"=> $this->client->email,
                "nom" => $client['prenom'] . ' ' . $client['nom'],
                "phone" => $client->phone,
            ],
            'paniers' => PanierResource::collection($this->whenLoaded('paniers')),
            "createdAt" => $this->created_at,
        ];
    }
}
