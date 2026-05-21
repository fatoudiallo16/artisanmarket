@extends('layouts.app')

@section('title', 'Ajouter un produit - Artisan Market')

@section('content')
<section class="am-dashboard">
    <div class="container am-container">
        <div class="am-dashboard-hero mb-4">
            <h1 class="am-section-title mb-2">Ajouter un produit</h1>
            <p class="mb-0" style="color:rgba(255,255,255,.82);">Creez une fiche claire avec prix, stock, categorie et description.</p>
        </div>

        <div class="am-panel">
            <form method="POST" action="{{ request()->routeIs('admin.*') ? route('admin.produits.store') : route('produits.store') }}" enctype="multipart/form-data" class="d-grid gap-3">
                @csrf
                <div class="am-form-grid">
                    <div class="am-field">
                        <label for="nom">Nom du produit</label>
                        <input id="nom" name="nom" value="{{ old('nom') }}" required>
                    </div>
                    <div class="am-field">
                        <label for="categorie_id">Categorie</label>
                        <select id="categorie_id" name="categorie_id" required>
                            <option value="">Choisir</option>
                            @foreach($categories as $categorie)
                                <option value="{{ $categorie->id }}" @selected(old('categorie_id') == $categorie->id)>{{ $categorie->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="am-field">
                        <label for="prix">Prix FCFA</label>
                        <input id="prix" type="number" min="0" step="1" name="prix" value="{{ old('prix') }}" required>
                    </div>
                    <div class="am-field">
                        <label for="stock">Stock</label>
                        <input id="stock" type="number" min="0" name="stock" value="{{ old('stock', 1) }}" required>
                    </div>
                    @if(Auth::user()->hasRole('admin'))
                        <div class="am-field">
                            <label for="vendeur_id">Vendeur</label>
                            <select id="vendeur_id" name="vendeur_id" required>
                                <option value="">Choisir</option>
                                @foreach($vendeurs as $vendeur)
                                    <option value="{{ $vendeur->id }}" @selected(old('vendeur_id') == $vendeur->id)>{{ $vendeur->nom_boutique }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
                <div class="am-field">
                    <label for="description">Description</label>
                    <textarea id="description" name="description">{{ old('description') }}</textarea>
                </div>
                @include('produits.partials.image-field')
                <div>
                    <button class="btn am-btn-primary" type="submit">Publier le produit</button>
                    <a class="btn btn-link" href="{{ route('home') }}">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
