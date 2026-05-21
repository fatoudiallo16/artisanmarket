<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ProduitController extends Controller
{
    // afficher la liste des produits
    public function index(Request $request): View
    {
        $query = Produit::with(['vendeur', 'categorie']);

        if ($request->filled('q')) {
            $search = $request->string('q')->toString();
            $query->where(function ($builder) use ($search) {
                $builder->where('nom', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $categoryColumn = Schema::hasColumn('categories', 'nom') ? 'nom' : 'nom_categorie';

        if ($request->filled('categorie')) {
            $category = $request->string('categorie')->lower()->toString();
            $query->whereHas('categorie', function ($builder) use ($category, $categoryColumn) {
                $builder->whereRaw("LOWER({$categoryColumn}) like ?", ["%{$category}%"]);
            });
        }

        match ($request->input('sort')) {
            'prix_asc' => $query->orderBy('prix'),
            'prix_desc' => $query->orderByDesc('prix'),
            'nouveautes' => $query->latest(),
            default => $query->latest(),
        };

        $produits = $query->paginate(12)->withQueryString();
        $categories = Categorie::withCount('produits')->get();

        return view('produits.index', compact('produits', 'categories', 'categoryColumn'));
    }

    // aficher un produit en detail
    public function show(Produit $produit): View
    {
        $produit->load(['vendeur', 'categorie']);

        $related = Produit::with(['vendeur', 'categorie'])
            ->where('categorie_id', $produit->categorie_id)
            ->where('id', '!=', $produit->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('produits.show', compact('produit', 'related'));
    }

    public function create(): View
    {
        $this->authorize('create', Produit::class);

        return view('produits.create', [
            'categories' => Categorie::orderBy(Schema::hasColumn('categories', 'nom') ? 'nom' : 'nom_categorie')->get(),
            'vendeurs' => Auth::user()->hasRole('admin') ? \App\Models\Vendeur::where('statut', 'approuve')->orderBy('nom_boutique')->get() : collect(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Produit::class);

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'categorie_id' => ['required', 'exists:categories,id'],
            'vendeur_id' => ['nullable', 'exists:vendeurs,id'],
        ]);

        $data['vendeur_id'] = $this->resolveVendeurId($request);
        Produit::create($data);

        return redirect()->route(Auth::user()->hasRole('admin') ? 'admin.dashboard' : 'home')->with('success', 'Produit cree avec succes.');
    }

    public function edit(Produit $produit): View
    {
        $this->authorize('update', $produit);

        return view('produits.edit', [
            'produit' => $produit,
            'categories' => Categorie::orderBy(Schema::hasColumn('categories', 'nom') ? 'nom' : 'nom_categorie')->get(),
        ]);
    }

    public function update(Request $request, Produit $produit): RedirectResponse
    {
        $this->authorize('update', $produit);

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'categorie_id' => ['required', 'exists:categories,id'],
        ]);

        $produit->update($data);

        return redirect()->route('produits.show', $produit)->with('success', 'Produit mis a jour.');
    }

    public function destroy(Produit $produit): RedirectResponse
    {
        $this->authorize('delete', $produit);

        $produit->delete();

        return redirect()->route('produits.index')->with('success', 'Produit supprime.');
    }

    private function resolveVendeurId(Request $request): int
    {
        $user = Auth::user();

        if ($user->hasRole('admin') && $request->filled('vendeur_id')) {
            return (int) $request->input('vendeur_id');
        }

        if ($user->vendeur) {
            return (int) $user->vendeur->id;
        }

        abort(403, 'Aucun profil vendeur associe a ce compte.');
    }
}
