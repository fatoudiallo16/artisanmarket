@extends('layouts.app')

@section('content')
@php
    $status = $produit->status ?? 'pending';
    $categoryName = $produit->categorie?->name ?? 'Artisanat';
@endphp

<div class="max-w-7xl mx-auto p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                {{ $produit->nom }}
            </h1>

            <p class="text-gray-500">
                Details du produit
            </p>
        </div>

        <a href="{{ route('vendeur.produits.index') }}"
           class="bg-gray-200 hover:bg-gray-300 px-5 py-3 rounded-xl">
            Retour
        </a>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-2xl shadow p-4">
            <img
                src="{{ $produit->image_url }}"
                alt="{{ $produit->nom }}"
                class="w-full h-[500px] object-cover rounded-xl">
        </div>

        <div class="bg-white rounded-2xl shadow p-8">
            <div class="mb-6">
                <span class="text-sm text-gray-500">Categorie</span>
                <h3 class="text-xl font-semibold">
                    {{ ucfirst($categoryName) }}
                </h3>
            </div>

            <div class="mb-6">
                <span class="text-sm text-gray-500">Prix</span>
                <h3 class="text-3xl font-bold text-amber-600">
                    {{ number_format((float) $produit->prix, 0, ' ', ' ') }} FCFA
                </h3>
            </div>

            <div class="mb-6">
                <span class="text-sm text-gray-500">Stock disponible</span>
                <h3 class="text-xl font-semibold">
                    {{ $produit->stock }}
                </h3>
            </div>

            <div class="mb-6">
                <span class="text-sm text-gray-500">Statut</span>
                <div class="mt-2">
                    @if($status === 'approved')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">Approuve</span>
                    @elseif($status === 'pending')
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">En attente</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">Refuse</span>
                    @endif
                </div>
            </div>

            <div>
                <span class="text-sm text-gray-500">Description</span>
                <p class="mt-2 text-gray-700 leading-relaxed">
                    {{ $produit->description ?: 'Aucune description.' }}
                </p>
            </div>

            <div class="flex gap-3 mt-8">
                <a href="{{ route('vendeur.produits.edit', $produit) }}"
                   class="bg-amber-600 hover:bg-amber-700 text-white px-5 py-3 rounded-xl">
                    Modifier
                </a>

                <form action="{{ route('vendeur.produits.destroy', $produit) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button
                        onclick="return confirm('Supprimer ce produit ?')"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-xl">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
