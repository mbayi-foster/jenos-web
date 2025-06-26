<?php

namespace App\Enum;

enum CommandeStatus: string
{
    case PENDING = 'pending';           // Commande créée, en attente d’acceptation
    case CONFIRMED = 'confirmed';         // Acceptée par le restaurant
    case PREPARING = 'preparing';         // En cours de préparation
    case READY_FOR_PICKUP = 'ready_for_pickup';  // Prête à être récupérée par le livreur
    case PICKED_UP = 'picked_up';         // Récupérée par le livreur
    case IN_TRANSIT = 'in_transit';        // En route vers le client
    case DELIVERED = 'delivered';         // Remise avec succès

    /* Terminaisons “anormales” */
    case CANCELED_BY_CUSTOMER = 'canceled_by_customer';   // Annulée par le client
    case CANCELED_BY_RESTAURANT = 'canceled_by_restaurant'; // Annulée par le restaurant (rupture, etc.)
    case DELIVERY_FAILED = 'delivery_failed';        // Échec de livraison (client absent, adresse introuvable…)
    case REFUSED = 'refused';                // Client a refusé la commande à la porte

    /* ——————————————————————
       Helpers pratiques
       —————————————————————— */

    /** Renvoie true si l’état est définitif (plus de transition possible). */
    public function isFinal(): bool
    {
        return match ($this) {
            self::DELIVERED,
            self::CANCELED_BY_CUSTOMER,
            self::CANCELED_BY_RESTAURANT,
            self::DELIVERY_FAILED,
            self::REFUSED => true,
            default => false,
        };
    }

    /** Libellé traduisible (facultatif). */
    public function label(): string
    {
        // Exemple : resources/lang/fr/order.php contiendra un tableau `status => ['pending' => 'En attente', …]`
        return __('commande.status.' . $this->value);
    }
}
