@extends('layouts.app')

@section('content')
@php
    $formRoute = request()->routeIs('admin.produits.*')
        ? 'admin.produits.store'
        : (request()->routeIs('produits.*') ? 'produits.store' : 'vendeur.produits.store');
@endphp

<div class="max-w-5xl mx-auto p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">
            Ajouter un produit
        </h1>
        <p class="text-gray-500">
            Publiez un nouveau produit artisanal.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <form
            action="{{ route($formRoute) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            @if(($vendeurs ?? collect())->isNotEmpty())
                <div>
                    <label class="block mb-2" for="vendeur_id">
                        Boutique vendeuse
                    </label>

                    <select
                        id="vendeur_id"
                        name="vendeur_id"
                        class="w-full border rounded-xl px-4 py-3">
                        <option value="">Choisir une boutique</option>
                        @foreach($vendeurs as $vendeur)
                            <option value="{{ $vendeur->id }}" {{ old('vendeur_id') == $vendeur->id ? 'selected' : '' }}>
                                {{ $vendeur->nom_boutique ?? $vendeur->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('vendeur_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            <div>
                <label class="block mb-2" for="nom">
                    Nom du produit
                </label>

                <input
                    id="nom"
                    type="text"
                    name="nom"
                    value="{{ old('nom') }}"
                    class="w-full border rounded-xl px-4 py-3">

                @error('nom')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-2" for="categorie_id">
                    Categorie
                </label>

                <select
                    id="categorie_id"
                    name="categorie_id"
                    class="w-full border rounded-xl px-4 py-3">
                    <option value="">Choisir une categorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('categorie_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name ?? $category->nom ?? $category->nom_categorie }}
                        </option>
                    @endforeach
                </select>

                @error('categorie_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-2" for="prix">
                    Prix (FCFA)
                </label>

                <input
                    id="prix"
                    type="number"
                    name="prix"
                    value="{{ old('prix') }}"
                    min="0"
                    step="0.01"
                    class="w-full border rounded-xl px-4 py-3">

                @error('prix')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-2" for="stock">
                    Stock
                </label>

                <input
                    id="stock"
                    type="number"
                    name="stock"
                    value="{{ old('stock', 1) }}"
                    min="0"
                    class="w-full border rounded-xl px-4 py-3">

                @error('stock')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-2" for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="6"
                    class="w-full border rounded-xl px-4 py-3">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block mb-2" for="image">
                    Image du produit
                </label>

                <input
                    id="image"
                    type="file"
                    name="image"
                    accept="image/*"
                    class="w-full border rounded-xl px-4 py-3">

                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-xl font-semibold">
                Publier le produit
            </button>
        </form>
    </div>
</div>
@endsection
