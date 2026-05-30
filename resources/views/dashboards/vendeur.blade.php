@extends('layouts.app')

@section('title', 'Tableau vendeur - Artisan Market')

@section('content')
@php($profile = Auth::user()->vendeurProfile)
<section class="am-dashboard">
    <div class="container am-container">
        <div class="am-dashboard-hero mb-4">
            <p class="text-uppercase fw-bold mb-2" style="color:#f5dfb5;">Espace vendeur</p>
            <h1 class="am-section-title mb-2">{{ $vendeur->nom_boutique ?? 'Ma boutique' }}</h1>
            <p class="mb-0" style="max-width:720px;color:rgba(255,255,255,.82);">Gerez votre boutique, ajoutez vos produits et gardez votre vitrine claire pour les clients.</p>
        </div>

        <div class="am-dashboard-grid mb-4">
            <div class="am-stat-card"><span>Produits</span><strong>{{ $produits->count() }}</strong></div>
            <div class="am-stat-card"><span>Categories</span><strong>{{ $categoriesCount }}</strong></div>
            <div class="am-stat-card"><span>Stock total</span><strong>{{ $produits->sum('stock') }}</strong></div>
            <div class="am-stat-card"><span>Statut</span><strong>{{ ucfirst($vendeur->statut ?? 'actif') }}</strong></div>
        </div>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="am-panel">
                    <h2 class="h3 fw-bold mb-3">Ma boutique</h2>
                    <form method="POST" action="{{ route('vendeur.boutique.update') }}" enctype="multipart/form-data" class="d-grid gap-3">
                        @csrf
                        @method('PATCH')
                        @if($profile?->image_url)
                            <div class="am-boutique-logo am-boutique-logo--sm mb-2">
                                <img src="{{ $profile->image_url }}" alt="Logo boutique">
                            </div>
                        @endif
                        <div class="am-field">
                            <label for="boutique_image">Logo / photo de la boutique</label>
                            <input id="boutique_image" name="image" type="file" accept="image/jpeg,image/png,image/webp">
                            @if($profile?->image)
                                <label class="d-block mt-2 small">
                                    <input type="checkbox" name="remove_image" value="1"> Supprimer le logo
                                </label>
                            @endif
                        </div>
                        <div class="am-field">
                            <label for="nom_boutique">Nom</label>
                            <input id="nom_boutique" name="nom_boutique" value="{{ old('nom_boutique', $profile->nom_boutique ?? $vendeur->nom_boutique ?? '') }}" required>
                        </div>
                        <div class="am-field">
                            <label for="description_boutique">Description</label>
                            <textarea id="description_boutique" name="description_boutique">{{ old('description_boutique', $profile->description_boutique ?? '') }}</textarea>
                        </div>
                        <div class="am-field">
                            <label for="telephone">Telephone</label>
                            <input id="telephone" name="telephone" value="{{ old('telephone', $profile->telephone ?? '') }}">
                        </div>
                        <div class="am-field">
                            <label for="adresse">Adresse</label>
                            <input id="adresse" name="adresse" value="{{ old('adresse', $profile->adresse ?? '') }}">
                        </div>
                        <button class="btn am-btn-primary" type="submit">Mettre a jour</button>
                        @if($vendeur?->isActive())
                            <a class="btn am-btn-ghost d-block mt-2 text-center" href="{{ route('boutiques.show', $vendeur) }}" target="_blank" rel="noopener">Voir ma boutique publique</a>
                        @endif
                    </form>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="am-panel">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                        <h2 class="h3 fw-bold mb-0">Mes produits</h2>
                        @can('create', App\Models\Produit::class)
                            @if($vendeur?->isActive())
                                <a class="btn am-btn-primary" href="{{ route('produits.create') }}">Ajouter un produit</a>
                            @else
                                <span class="btn am-btn-primary disabled" title="Boutique en attente de validation">Ajouter un produit</span>
                                <p class="text-muted small mt-2 mb-0">Votre boutique doit être <strong>approuvée</strong> par un admin pour publier des produits.</p>
                            @endif
                        @endcan
                    </div>
                    @include('produits.partials.grid', ['produits' => $produits, 'allowFallback' => false])
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
