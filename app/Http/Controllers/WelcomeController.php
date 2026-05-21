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
        $categoryColumn = Schema::hasColumn('categories', 'nom') ? 'nom' : 'nom_categorie';

        $produitsEnVedette = Produit::query()
            ->with(['vendeur', 'categorie'])
            ->where('stock', '>', 0)
            ->latest()
            ->limit(6)
            ->get();

        $categories = Categorie::query()
            ->withCount('produits')
            ->orderByDesc('produits_count')
            ->limit(6)
            ->get();

        $latestAnnonce = Annonce::query()->latest()->first();

        return view('index', compact(
            'produitsEnVedette',
            'categories',
            'categoryColumn',
            'latestAnnonce'
        ));
    }
}
