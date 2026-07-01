<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Avis;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvisController extends Controller
{
    public function __construct()
    {
    }

    public function store(Request $request, Produit $produit)
    {
        $user = Auth::user();

        // 1. Check if user already reviewed this product
        $alreadyReviewed = Avis::where('user_id', $user->id)
            ->where('produit_id', $produit->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Vous avez déjà laissé un avis sur ce produit.');
        }

        // 2. Check if user has purchased the product in a paid order
        $hasPurchased = Commande::where('user_id', $user->id)
            ->where('statut', OrderStatus::PAID)
            ->whereHas('lignecommandes', function ($q) use ($produit) {
                $q->where('produit_id', $produit->id);
            })->exists();

        if (!$hasPurchased) {
            abort(403, 'Vous devez avoir acheté ce produit pour laisser un avis.');
        }

        // 3. Validate request
        $data = $request->validate([
            'note' => ['required', 'integer', 'min:1', 'max:5'],
            'commentaire' => ['nullable', 'string', 'max:1000'],
        ]);

        // 4. Create review
        Avis::create([
            'user_id' => $user->id,
            'produit_id' => $produit->id,
            'note' => $data['note'],
            'commentaire' => $data['commentaire'],
        ]);

        return back()->with('success', 'Votre avis a été publié avec succès.');
    }
}
