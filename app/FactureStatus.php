<?php
// app/Enums/InvoiceStatus.php

namespace App;

enum FactureStatus: string
{
    case PENDING      = 'pending';       // Facture créée, en attente de paiement
    case PAID         = 'paid';          // Payée entièrement
    case PARTIALLY_PAID = 'partially_paid'; // Payée partiellement (ex: acomptes)
    case OVERDUE      = 'overdue';       // Retard de paiement (délai dépassé)
    case CANCELED     = 'canceled';      // Annulée manuellement ou automatiquement
    case REFUNDED     = 'refunded';      // Remboursée totalement
    case FAILED       = 'failed';        // Échec de paiement (ex: carte refusée)

    public function isFinal(): bool
    {
        return match ($this) {
            self::PAID,
            self::CANCELED,
            self::REFUNDED,
            self::FAILED => true,
            default => false,
        };
    }

    public function label(): string
    {
        return __('facture.status.' . $this->value);
    }
}
