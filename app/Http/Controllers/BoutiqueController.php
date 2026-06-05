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
            ->where('stock', '>', 0)
            ->with('categorie')
            ->latest()
            ->get();

        return view('public.boutiques.show', compact('vendeur', 'produits'));
    }
}
