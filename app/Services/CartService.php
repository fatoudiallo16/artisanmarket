<?php

namespace App\Services;

use App\Exceptions\InsufficientStockException;
use App\Models\Lignepanier;
use App\Models\Panier;
use App\Models\Produit;
use Illuminate\Support\Facades\Auth;

class CartService
{
    /**
     * Récupérer ou créer le panier de l'utilisateur
     */
    public function getOrCreateCart(int $userId = null): Panier
    {
        $userId = $userId ?? Auth::id();
        return Panier::firstOrCreate(['user_id' => $userId]);
    }

    /**
     * Ajouter un produit au panier
     */
    public function addToCart(int $produitId, int $quantite = 1, int $userId = null): Lignepanier
    {
        $userId = $userId ?? Auth::id();
        $panier = $this->getOrCreateCart($userId);
        $produit = Produit::findOrFail($produitId);

        $article = Lignepanier::firstOrNew([
            'panier_id' => $panier->id,
            'produit_id' => $produitId,
        ]);

        $newQuantite = $article->exists ? $article->quantite + $quantite : $quantite;

        if ($produit->stock < $newQuantite) {
            throw new InsufficientStockException($produit->nom, $produit->stock, $newQuantite);
        }

        $article->quantite = $newQuantite;
        $article->prix_unitaire = $produit->prix;
        $article->save();

        return $article;
    }

    /**
     * Mettre à jour la quantité d'un article
     */
    public function updateQuantity(int $produitId, int $quantite, int $userId = null): ?Lignepanier
    {
        $userId = $userId ?? Auth::id();
        $panier = $this->getOrCreateCart($userId);
        $produit = Produit::findOrFail($produitId);

        if ($quantite <= 0) {
            $this->removeFromCart($produitId, $userId);
            return null;
        }

        if ($produit->stock < $quantite) {
            throw new InsufficientStockException($produit->nom, $produit->stock, $quantite);
        }

        $article = Lignepanier::where('panier_id', $panier->id)
            ->where('produit_id', $produitId)
            ->firstOrFail();

        $article->update(['quantite' => $quantite]);

        return $article;
    }

    /**
     * Supprimer un article du panier
     */
    public function removeFromCart(int $produitId, int $userId = null): void
    {
        $userId = $userId ?? Auth::id();
        $panier = Panier::where('user_id', $userId)->first();

        if (!$panier) {
            return;
        }

        Lignepanier::where('panier_id', $panier->id)
            ->where('produit_id', $produitId)
            ->delete();
    }

    /**
     * Vider le panier
     */
    public function clearCart(int $userId = null): void
    {
        $userId = $userId ?? Auth::id();
        $panier = Panier::where('user_id', $userId)->first();

        if ($panier) {
            Lignepanier::where('panier_id', $panier->id)->delete();
        }
    }

    /**
     * Récupérer les articles du panier
     */
    public function getCartItems(int $userId = null): \Illuminate\Database\Eloquent\Collection
    {
        $userId = $userId ?? Auth::id();
        $panier = $this->getOrCreateCart($userId);

        return Lignepanier::with('produit')
            ->where('panier_id', $panier->id)
            ->get();
    }

    /**
     * Calculer le montant total du panier
     */
    public function calculateCartTotal(int $userId = null): float
    {
        return $this->getCartItems($userId)->sum(function ($article) {
            return $article->quantite * $article->prix_unitaire;
        });
    }

    /**
     * Obtenir le nombre d'articles dans le panier
     */
    public function getCartCount(int $userId = null): int
    {
        return $this->getCartItems($userId)->sum('quantite');
    }
}
