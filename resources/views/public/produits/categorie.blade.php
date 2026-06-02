@extends('layouts.app')

@php($categoryName = $categorie->{$categoryColumn} ?? $categorie->name ?? 'Categorie')

@section('title', ucfirst($categoryName) . ' | ArtisanMarket')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-8">
            <a href="{{ route('produits.index') }}" class="text-amber-700 hover:text-amber-800 font-semibold">
                Retour aux produits
            </a>

            <h1 class="text-4xl font-bold text-slate-900 mt-4">
                {{ ucfirst($categoryName) }}
            </h1>

            @if($categorie->description)
                <p class="text-gray-500 mt-2 max-w-3xl">
                    {{ $categorie->description }}
                </p>
            @endif
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($produits as $produit)
                <article class="bg-white rounded-2xl shadow overflow-hidden border border-gray-100">
                    <a href="{{ route('produits.show', $produit) }}" class="block">
                        <img
                            src="{{ $produit->image_url }}"
                            alt="{{ $produit->nom }}"
                            class="w-full h-60 object-cover"
                        >
                    </a>

                    <div class="p-4">
                        <h2 class="font-semibold text-lg text-slate-900">
                            <a href="{{ route('produits.show', $produit) }}" class="hover:text-amber-700">
                                {{ $produit->nom }}
                            </a>
                        </h2>

                        <p class="text-amber-700 font-bold mt-2">
                            {{ number_format((float) $produit->prix, 0, ' ', ' ') }} FCFA
                        </p>

                        <a
                            href="{{ route('produits.show', $produit) }}"
                            class="block text-center bg-amber-600 hover:bg-amber-700 text-white py-3 rounded-xl mt-4 font-semibold"
                        >
                            Voir le produit
                        </a>
                    </div>
                </article>
            @empty
                <div class="md:col-span-2 lg:col-span-4 text-center py-10 text-gray-500">
                    Aucun produit disponible dans cette categorie.
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $produits->links() }}
        </div>
    </div>
</div>
@endsection
