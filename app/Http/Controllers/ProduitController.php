<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProduitController extends Controller
{
    // afficher la liste des produits
    public function index(): View
    {
        $produits = Produit::latest()->paginate(12);

        return view('produits.index', compact('produits'));
    }

    // aficher un produit en detail
    public function show(Produit $produit): View
    {
        return view('produits.show', compact('produit'));
    }

    public function create(): View
    {
        $this->authorize('create', Produit::class);

        return view('produits.create');
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

        return redirect()->route('produits.index')->with('success', 'Produit cree avec succes.');
    }

    public function edit(Produit $produit): View
    {
        $this->authorize('update', $produit);

        return view('produits.edit', compact('produit'));
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
