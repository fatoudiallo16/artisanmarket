@extends('layouts.app')

@section('title', 'Produits | ArtisanMarket')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-slate-900">
                Nos produits artisanaux
            </h1>
            <p class="text-gray-500 mt-2">
                Decouvrez les creations de nos artisans.
            </p>
        </div>

        <form method="GET" action="{{ route('produits.index') }}" class="grid md:grid-cols-4 gap-4 mb-8">
            <input
                type="text"
                name="q"
                value="{{ request('q', request('search')) }}"
                placeholder="Rechercher un produit..."
                class="border border-gray-200 rounded-xl px-4 py-3"
            >

            <select name="categorie" class="border border-gray-200 rounded-xl px-4 py-3">
                <option value="">Toutes les categories</option>
                @foreach($categories as $category)
                    @php($categoryName = $category->name ?? 'Categorie')
                    <option value="{{ $category->id }}" {{ 
                        (string) request('categorie') === (string) $category->id || 
                        strtolower(request('categorie')) === strtolower($categoryName) 
                        ? 'selected' : '' 
                    }}>
                        {{ ucfirst($categoryName) }}
                    </option>
                @endforeach
            </select>

            <select name="sort" class="border border-gray-200 rounded-xl px-4 py-3">
                <option value="nouveautes" {{ request('sort') === 'nouveautes' ? 'selected' : '' }}>Plus recents</option>
                <option value="prix_asc" {{ request('sort') === 'prix_asc' ? 'selected' : '' }}>Prix croissant</option>
                <option value="prix_desc" {{ request('sort') === 'prix_desc' ? 'selected' : '' }}>Prix decroissant</option>
            </select>

            <button class="bg-amber-600 hover:bg-amber-700 text-white rounded-xl px-5 py-3 font-semibold">
                Rechercher
            </button>
        </form>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($produits as $produit)
                @php($categoryName = $produit->categorie?->name ?? 'Artisanat')

                @include('composants.cartes.carte-produits', [
                    'id' => $produit->id,
                    'title' => $produit->nom,
                    'description' => \Illuminate\Support\Str::limit($produit->description, 90),
                    'price' => number_format((float) $produit->prix, 0, ' ', ' ') . ' FCFA',
                    'category' => ucfirst($categoryName),
                    'badge' => $produit->stock > 0 ? 'Disponible' : 'Rupture',
                    'image' => $produit->image_url,
                    'url' => route('produits.show', $produit),
                ])
            @empty
                <div class="md:col-span-2 lg:col-span-4 text-center py-10 text-gray-500">
                    Aucun produit disponible.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $produits->links() }}
        </div>
    </div>
</div>
@endsection
