<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Exceptions\EmptyCartException;
use App\Exceptions\InsufficientStockException;
use App\Exceptions\OrderException;
use App\Models\Commande;
use App\Models\Lignecommande;
use App\Models\Lignepanier;
use App\Models\Paiement;
use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Créer une commande à partir du panier avec vérification de stock.
     */
    public function createOrderFromCart(int $userId): Commande
    {
        $panier = Panier::where('user_id', $userId)->first();
        
        if (!$panier) {
            throw OrderException::cartNotFound();
        }

        $articles = Lignepanier::where('panier_id', $panier->id)->get();
        
        if ($articles->isEmpty()) {
            throw new EmptyCartException();
        }

        return DB::transaction(function () use ($panier, $articles, $userId) {
            // 1. Créer la commande
            $commande = Commande::create([
                'user_id' => $userId,
                'statut' => OrderStatus::PENDING,
            ]);

            // 2. Transférer les articles du panier vers lignecommande
            $montantTotal = 0;
            foreach ($articles as $article) {
                // Vérifier le stock avec verrou pessimiste (évite race condition)
                $produit = Produit::lockForUpdate()->find($article->produit_id);
                if (!$produit || $produit->stock < $article->quantite) {
                    $nom = $produit?->nom ?? 'Produit #'.$article->produit_id;
                    $stock = $produit?->stock ?? 0;
                    throw new InsufficientStockException($nom, $stock, $article->quantite);
                }

                // Créer la ligne de commande
                Lignecommande::create([
                    'commande_id' => $commande->id,
                    'produit_id' => $article->produit_id,
                    'quantite' => $article->quantite,
                    'prix_unitaire' => $article->prix_unitaire,
                ]);

                // Décrémenter le stock
                $produit->decrement('stock', $article->quantite);

                $montantTotal += $article->quantite * $article->prix_unitaire;
            }

            // 3. Créer le paiement initial
            Paiement::create([
                'commande_id' => $commande->id,
                'montant' => $montantTotal,
                'mode_paiement' => 'en_ligne',
                'statut' => PaymentStatus::PENDING,
                'date_paiement' => now(),
            ]);

            // 4. Vider le panier
            Lignepanier::where('panier_id', $panier->id)->delete();

            return $commande;
        });
    }

    /**
     * Calculer le montant total d'une commande
     */
    public function calculateOrderTotal(Commande $commande): float
    {
        return $commande->lignecommandes->sum(function ($ligne) {
            return $ligne->quantite * $ligne->prix_unitaire;
        });
    }

    /**
     * Annuler une commande et restaurer le stock.
     */
    public function cancelOrder(Commande $commande): void
    {
        if ($commande->statut === OrderStatus::PAID) {
            throw OrderException::cannotCancel();
        }

        DB::transaction(function () use ($commande) {
            foreach ($commande->lignecommandes as $ligne) {
                if ($ligne->produit) {
                    $ligne->produit->increment('stock', $ligne->quantite);
                }
            }

            $commande->update(['statut' => OrderStatus::CANCELLED]);

            $paiement = Paiement::where('commande_id', $commande->id)->first();
            if ($paiement && $paiement->statut === PaymentStatus::PENDING) {
                $paiement->update(['statut' => PaymentStatus::FAILED]);
            }
        });
    }

    /**
     * Mettre à jour le statut d'une commande.
     */
    public function updateOrderStatus(Commande $commande, OrderStatus $statut): void
    {
        $commande->update(['statut' => $statut]);
    }
}
