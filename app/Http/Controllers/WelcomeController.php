<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        $categoryColumn = match (true) {
            Schema::hasColumn('categories', 'name') => 'name',
            Schema::hasColumn('categories', 'nom') => 'nom',
            default => 'nom_categorie',
        };

        $produitsEnVedette = Produit::query()
            ->with(['vendeur', 'categorie'])
            ->where('stock', '>', 0)
            ->latest()
            ->limit(10)
            ->get();

        $categories = Categorie::query()
            ->withCount('produits')
            ->orderByDesc('produits_count')
            ->limit(7)
            ->get();

        $latestAnnonce = Annonce::query()->latest()->first();

        return view('public.accueil.welcome', compact(
            'produitsEnVedette',
            'categories',
            'categoryColumn',
            'latestAnnonce'
        ));
    }
}
