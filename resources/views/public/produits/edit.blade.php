@extends('layouts.app')

@section('title', 'Modifier un produit - Artisan Market')

@section('content')
<section class="am-dashboard">
    <div class="container am-container">
        <div class="am-dashboard-hero mb-4">
            <h1 class="am-section-title mb-2">Modifier {{ $produit->nom }}</h1>
        </div>

        <div class="am-panel">
            <form method="POST" action="{{ request()->routeIs('admin.*') ? route('admin.produits.update', $produit) : route('produits.update', $produit) }}" enctype="multipart/form-data" class="d-grid gap-3">
                @csrf
                @method('PUT')
                <div class="am-form-grid">
                    <div class="am-field">
                        <label for="nom">Nom</label>
                        <input id="nom" name="nom" value="{{ old('nom', $produit->nom) }}" required>
                    </div>
                    <div class="am-field">
                        <label for="categorie_id">Catégorie</label>
                        <select id="categorie_id" name="categorie_id" required>
                            @foreach($categories as $categorie)
                                @php($categoryName = $categorie->nom ?? $categorie->nom_categorie)
                                <option value="{{ $categorie->id }}" @selected(old('categorie_id', $produit->categorie_id) == $categorie->id)>{{ $categoryName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="am-field">
                        <label for="prix">Prix FCFA</label>
                        <input id="prix" type="number" min="0" step="1" name="prix" value="{{ old('prix', $produit->prix) }}" required>
                    </div>
                    <div class="am-field">
                        <label for="stock">Stock</label>
                        <input id="stock" type="number" min="0" name="stock" value="{{ old('stock', $produit->stock) }}" required>
                    </div>
                </div>
                <div class="am-field">
                    <label for="description">Description</label>
                    <textarea id="description" name="description">{{ old('description', $produit->description) }}</textarea>
                </div>
                @include('public.produits.partials.image-field', ['currentUrl' => $produit->image ? $produit->image_url : null])
                <p class="text-muted small mb-0">Boutique : <strong>{{ $produit->vendeur->nom_boutique ?? '—' }}</strong></p>
                <button class="btn am-btn-primary" type="submit">Enregistrer</button>
            </form>
        </div>
    </div>
</section>
@endsection
