<?php

namespace App\Services;

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
     * Créer une commande à partir du panier (méthode de CartService)
     */
    public function createFromCart(int $userId, array $articles): Commande
    {
        return DB::transaction(function () use ($userId, $articles) {
            // Créer la commande
            $commande = Commande::create([
                'user_id' => $userId,
                'statut' => 'en_attente',
            ]);

            // Transférer les articles
            $montantTotal = 0;
            foreach ($articles as $article) {
                Lignecommande::create([
                    'commande_id' => $commande->id,
                    'produit_id' => $article['produit_id'],
                    'quantite' => $article['quantite'],
                    'prix_unitaire' => $article['prix_unitaire'],
                ]);
                $montantTotal += $article['quantite'] * $article['prix_unitaire'];
            }

            // Créer le paiement
            Paiement::create([
                'commande_id' => $commande->id,
                'montant' => $montantTotal,
                'mode_paiement' => 'en_attente',
                'statut' => 'en_attente',
                'date_paiement' => now(),
            ]);

            return $commande;
        });
    }

    /**
     * Créer une commande à partir du panier (méthode complète avec vérification stock)
     */
    public function createOrderFromCart(int $userId): Commande
    {
        $panier = Panier::where('user_id', $userId)->first();
        
        if (!$panier) {
            throw new \Exception('Panier non trouvé.');
        }

        $articles = Lignepanier::where('panier_id', $panier->id)->get();
        
        if ($articles->isEmpty()) {
            throw new \Exception('Panier vide.');
        }

        return DB::transaction(function () use ($panier, $articles, $userId) {
            // 1. Créer la commande
            $commande = Commande::create([
                'user_id' => $userId,
                'statut' => 'en_attente',
            ]);

            // 2. Transférer les articles du panier vers lignecommande
            $montantTotal = 0;
            foreach ($articles as $article) {
                // Vérifier le stock
                $produit = Produit::find($article->produit_id);
                if (!$produit || $produit->stock < $article->quantite) {
                    throw new \Exception("Stock insuffisant pour {$produit->nom}");
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
                'mode_paiement' => 'en_attente',
                'statut' => 'en_attente',
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
     * Annuler une commande
     */
    public function cancel(int $commandeId): bool
    {
        return DB::transaction(function () use ($commandeId) {
            $commande = Commande::findOrFail($commandeId);

            // Ne peut annuler que si pas encore payée
            if ($commande->statut === 'payee') {
                throw new \Exception('Impossible d\'annuler une commande payée.');
            }

            $commande->update(['statut' => 'annulee']);

            // Annuler le paiement associé
            $paiement = Paiement::where('commande_id', $commandeId)->first();
            if ($paiement && $paiement->statut !== 'paye') {
                $paiement->update(['statut' => 'annulee']);
            }

            return true;
        });
    }

    /**
     * Mettre à jour le statut d'une commande
     */
    public function updateStatus(int $commandeId, string $statut): Commande
    {
        $commande = Commande::findOrFail($commandeId);
        $commande->update(['statut' => $statut]);

        return $commande;
    }

    /**
     * Annuler une commande (version model)
     */
    public function cancelOrder(Commande $commande): void
    {
        if ($commande->statut === 'payee') {
            throw new \Exception('Impossible d\'annuler une commande payée.');
        }

        DB::transaction(function () use ($commande) {
            // Restaurer le stock
            foreach ($commande->lignecommandes as $ligne) {
                $ligne->produit->increment('stock', $ligne->quantite);
            }

            $commande->update(['statut' => 'annulee']);
        });
    }

    /**
     * Mettre à jour le statut d'une commande (version model)
     */
    public function updateOrderStatus(Commande $commande, string $statut): void
    {
        $validStatuts = ['en_attente', 'en_cours', 'payee', 'annulee'];
        
        if (!in_array($statut, $validStatuts)) {
            throw new \Exception("Statut invalide: {$statut}");
        }

        $commande->update(['statut' => $statut]);
    }
}

