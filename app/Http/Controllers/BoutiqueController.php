<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Vendeur;
use Illuminate\View\View;

class BoutiqueController extends Controller
{
    public function show(Vendeur $vendeur): View
    {
        $vendeur->load('user.vendeurProfile');

        $produits = Produit::query()
            ->where('vendeur_id', $vendeur->id)
            ->where('status', 'approved')
            ->where('stock', '>', 0)
            ->with('categorie')
            ->latest()
            ->paginate(12);

        return view('public.boutiques.show', compact('vendeur', 'produits'));
    }
}
