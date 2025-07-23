<?php

namespace App\Http\Controllers\Api\Livreur;

use App\Enum\OrderStatus;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommandeResource;
use App\Models\Commande;
use Illuminate\Http\Request;

class CommandeLivreurController extends Controller
{
    public function commandes($id, $status)
    {
        $commandes = Commande::where('livreur_id', $id)
            ->where('status', $status)
            ->get();

        return ApiResponse::success(data: $commandes, message: 'Commandes retrieved successfully');
    }

    public function event(Request $request, string $id)
    {
        $validated = $request->validate([
            'event' => 'required|string',
            'mot' => 'string|max:255',
        ]);
        $commande = Commande::find($id);
        if (!$commande) {
            return ApiResponse::error(message: 'Commande not found', code: 404);
        }
        if (!$commande->livreur) {
            return ApiResponse::error(message: 'Unauthorized access', code: 403);
        }
        switch ($validated['event']) {
            case OrderStatus::PICKED_UP->value:
                if ($commande->status !== OrderStatus::READY_FOR_PICKUP) {
                    return ApiResponse::error(message: 'Commande is not ready for pickup', code: 400);
                }
                $commande->status = OrderStatus::PICKED_UP;
                $commande->save();
                $commande->rapports()->create([
                    'contenue' => $validated['mot'] ?? '',
                    'label' => "La commande a été récupérée",
                    'livreur_id' => $commande->livreur_id,
                ]);
                break;
            case OrderStatus::PROGRESS->value:
                if ($commande->status !== OrderStatus::PICKED_UP) {
                    return ApiResponse::error(message: 'Commande has not been picked up yet', code: 400);
                }
                $commande->status = OrderStatus::PROGRESS;
                $commande->save();
                $commande->rapports()->create([
                    'contenue' => $validated['mot'] ?? '',
                    'label' => "Livreur en route",
                    'livreur_id' => $commande->livreur_id,
                ]);
                break;
            case OrderStatus::ARRIVED->value:
                if ($commande->status !== OrderStatus::PROGRESS) {
                    return ApiResponse::error(message: 'Commande is not in progress', code: 400);
                }
                $commande->status = OrderStatus::ARRIVED;
                $commande->save();
                $commande->rapports()->create([
                    'contenue' => $validated['mot'] ?? '',
                    'label' => "Livreur arrivée au point de livraison",
                    'livreur_id' => $commande->livreur_id,
                ]);
                break;
            case OrderStatus::DELIVERED->value:
                if ($commande->status !== OrderStatus::ARRIVED) {
                    return ApiResponse::error(message: 'Commande has not arrived yet', code: 400);
                }
                $commande->status = OrderStatus::DELIVERED;
                $commande->save();
                $commande->rapports()->create([
                    'contenue' => $validated['mot'] ?? '',
                    'label' => "Livraison réussie",
                    'livreur_id' => $commande->livreur_id,
                ]);
                break;
            case OrderStatus::DELIVERY_FAILED->value:
                if ($commande->status !== OrderStatus::ARRIVED && $commande->status !== OrderStatus::PICKED_UP && $commande->status !== OrderStatus::PROGRESS) {
                    return ApiResponse::error(message: 'Commande cannot be marked as failed at this stage', code: 400);
                }
                $commande->status = OrderStatus::DELIVERY_FAILED;
                $commande->save();
                $commande->rapports()->create([
                    'contenue' => $validated['mot'] ?? '',
                    'label' => "Livraison échouée",
                    'livreur_id' => $commande->livreur_id,
                ]);
                break;
            default:
                return ApiResponse::error(message: 'Invalid event type', code: 400);
                break;
        }

        return ApiResponse::success(data: new CommandeResource($commande), message: 'Event processed successfully');
    }
}
