<?php

namespace App\Services;

use App\Models\Paiement;
use App\Models\Commande;

class PaymentService
{
    /**
     * Créer un paiement
     */
    public function createPayment(int $commandeId, float $montant, string $modePaiement): Paiement
    {
        $commande = Commande::findOrFail($commandeId);

        return Paiement::create([
            'commande_id' => $commandeId,
            'montant' => $montant,
            'mode_paiement' => $modePaiement,
            'statut' => 'en_attente',
            'date_paiement' => now(),
        ]);
    }

    /**
     * Marquer un paiement comme payé
     */
    public function markAsPaid(Paiement $paiement): void
    {
        $paiement->update(['statut' => 'paye']);
        $paiement->commande->update(['statut' => 'payee']);
    }

    /**
     * Marquer un paiement comme échoué
     */
    public function markAsFailed(Paiement $paiement): void
    {
        $paiement->update(['statut' => 'echoue']);
    }

    /**
     * Rembourser un paiement
     */
    public function refundPayment(Paiement $paiement): void
    {
        if ($paiement->statut !== 'paye') {
            throw new \Exception('Seuls les paiements payés peuvent être remboursés.');
        }

        $paiement->update(['statut' => 'rembourse']);
        
        // Restaurer le stock
        foreach ($paiement->commande->lignecommandes as $ligne) {
            $ligne->produit->increment('stock', $ligne->quantite);
        }

        $paiement->commande->update(['statut' => 'annulee']);
    }

    /**
     * Obtenir le montant total payé pour une commande
     */
    public function getTotalPaidForOrder(Commande $commande): float
    {
        return $commande->paiements()
            ->where('statut', 'paye')
            ->sum('montant');
    }

    /**
     * Vérifier si une commande est totalement payée
     */
    public function isOrderFullyPaid(Commande $commande): bool
    {
        $totalDue = $commande->lignecommandes->sum(function ($ligne) {
            return $ligne->quantite * $ligne->prix_unitaire;
        });

        $totalPaid = $this->getTotalPaidForOrder($commande);

        return $totalPaid >= $totalDue;
    }

    /**
     * Obtenir le montant restant à payer
     */
    public function getRemainingAmount(Commande $commande): float
    {
        $totalDue = $commande->lignecommandes->sum(function ($ligne) {
            return $ligne->quantite * $ligne->prix_unitaire;
        });

        $totalPaid = $this->getTotalPaidForOrder($commande);

        return max(0, $totalDue - $totalPaid);
    }
}
