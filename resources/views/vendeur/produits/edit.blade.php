@extends('layouts.app')

@section('content')
@php
    $formRoute = request()->routeIs('admin.produits.*')
        ? 'admin.produits.update'
        : (request()->routeIs('produits.*') ? 'produits.update' : 'vendeur.produits.update');
@endphp

<div class="max-w-5xl mx-auto p-6">
    <div class="mb-8">
        <h1 class="text-3xl font-bold">
            Modifier le produit
        </h1>
        <p class="text-gray-500">
            Mettre a jour les informations du produit.
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <form
            action="{{ route($formRoute, $produit) }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-2" for="nom">
                    Nom du produit
                </label>

                <input
                    id="nom"
                    type="text"
                    name="nom"
                    value="{{ old('nom', $produit->nom) }}"
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
                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ (int) old('categorie_id', $produit->categorie_id) === (int) $category->id ? 'selected' : '' }}>
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
                    Prix
                </label>

                <input
                    id="prix"
                    type="number"
                    name="prix"
                    value="{{ old('prix', $produit->prix) }}"
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
                    value="{{ old('stock', $produit->stock) }}"
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
                    class="w-full border rounded-xl px-4 py-3">{{ old('description', $produit->description) }}</textarea>
            </div>

            <div>
                <label class="block mb-2" for="image">
                    Image du produit
                </label>

                @if($produit->image)
                    <img
                        src="{{ $produit->image_url }}"
                        alt="{{ $produit->nom }}"
                        class="w-32 h-32 object-cover rounded-xl mb-4">

                    <label class="flex items-center gap-2 mb-4">
                        <input type="checkbox" name="remove_image" value="1">
                        <span>Retirer l'image actuelle</span>
                    </label>
                @endif

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
                Mettre a jour
            </button>
        </form>
    </div>
</div>
@endsection
