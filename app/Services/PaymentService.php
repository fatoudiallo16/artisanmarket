<?php

namespace App\Services;

use App\Models\Paiement;
use App\Models\Commande;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    /**
     * Créer un paiement
     */
    public function createPayment(int $commandeId, float $montant, string $modePaiement): Paiement
    {
        Commande::findOrFail($commandeId);

        return Paiement::create([
            'commande_id' => $commandeId,
            'montant' => $montant,
            'mode_paiement' => $modePaiement,
            'statut' => 'en_attente',
            'date_paiement' => now(),
        ]);
    }

    /**
     * Enregistrer le paiement en base et générer la facture PDF.
     */
    public function markAsPaid(Paiement $paiement, ?string $modePaiement = null): Paiement
    {
        return DB::transaction(function () use ($paiement, $modePaiement) {
            $updates = [
                'statut' => 'paye',
                'date_paiement' => now(),
            ];

            if ($modePaiement) {
                $updates['mode_paiement'] = $modePaiement;
            }

            if (!$paiement->numero_facture) {
                $updates['numero_facture'] = $this->invoiceService->generateInvoiceNumber($paiement);
            }

            $paiement->update($updates);
            $paiement->commande->update(['statut' => 'payee']);

            return $this->invoiceService->generateAndStore($paiement->fresh());
        });
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

        foreach ($paiement->commande->lignecommandes as $ligne) {
            if ($ligne->produit) {
                $ligne->produit->increment('stock', $ligne->quantite);
            }
        }

        $paiement->commande->update(['statut' => 'annulee']);
    }

    public function getTotalPaidForOrder(Commande $commande): float
    {
        return $commande->paiements()
            ->where('statut', 'paye')
            ->sum('montant');
    }

    public function isOrderFullyPaid(Commande $commande): bool
    {
        $totalDue = $commande->lignecommandes->sum(function ($ligne) {
            return $ligne->quantite * $ligne->prix_unitaire;
        });

        return $this->getTotalPaidForOrder($commande) >= $totalDue;
    }

    public function getRemainingAmount(Commande $commande): float
    {
        $totalDue = $commande->lignecommandes->sum(function ($ligne) {
            return $ligne->quantite * $ligne->prix_unitaire;
        });

        return max(0, $totalDue - $this->getTotalPaidForOrder($commande));
    }
}
