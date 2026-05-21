@extends('layouts.app')

@php
    use App\Support\ProduitVisual;

    $theme = ProduitVisual::forProduit($produit);
    $imageUrl = ProduitVisual::imageUrl($produit);
    $categoryName = $produit->categorie?->nom ?? $produit->categorie?->nom_categorie ?? $theme['label'];
    $vendor = $produit->vendeur->nom_boutique ?? $produit->vendeur->name ?? 'Artisan';
    $inStock = (int) $produit->stock > 0;
@endphp

@section('title', $produit->nom . ' - Artisan Market')

@section('content')
<section class="am-product-detail">
    <div class="container am-container">
        <nav class="am-breadcrumb" aria-label="Fil d'Ariane">
            <a href="{{ url('/') }}">Accueil</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('produits.index') }}">Catalogue</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('produits.index', ['categorie' => $categoryName]) }}">{{ ucfirst($categoryName) }}</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">{{ $produit->nom }}</span>
        </nav>

        <div class="am-product-detail-grid">
            <div class="am-product-gallery">
                <div class="am-product-media am-product-media--detail am-product-media--photo">
                    <span class="am-product-category-pill">{{ ucfirst($categoryName) }}</span>
                    <img src="{{ $imageUrl }}" alt="{{ $produit->nom }}">
                </div>
            </div>

            <div class="am-product-info">
                <span class="am-product-detail-tag">{{ ucfirst($categoryName) }}</span>
                <h1 class="am-product-detail-title">{{ $produit->nom }}</h1>
                <p class="am-product-detail-vendor">
                    Par <strong>{{ $vendor }}</strong>
                </p>

                <div class="am-product-price-block">
                    <span class="am-price am-price--xl">{{ number_format((float) $produit->prix, 0, ',', ' ') }} <small>FCFA</small></span>
                    @if($inStock)
                        <span class="am-stock-badge am-stock-badge--in">En stock · {{ $produit->stock }} unité(s)</span>
                    @else
                        <span class="am-stock-badge am-stock-badge--out">Rupture de stock</span>
                    @endif
                </div>

                <div class="am-product-description">
                    <h2>Description</h2>
                    <p>{{ $produit->description ?? 'Produit artisanal sélectionné par Artisan Market, réalisé à la main par un artisan malien.' }}</p>
                </div>

                <dl class="am-product-specs">
                    <div>
                        <dt>Catégorie</dt>
                        <dd>{{ ucfirst($categoryName) }}</dd>
                    </div>
                    <div>
                        <dt>Boutique</dt>
                        <dd>{{ $vendor }}</dd>
                    </div>
                    <div>
                        <dt>Référence</dt>
                        <dd>#{{ str_pad((string) $produit->id, 5, '0', STR_PAD_LEFT) }}</dd>
                    </div>
                    <div>
                        <dt>Disponibilité</dt>
                        <dd>{{ $inStock ? 'Livraison possible' : 'Indisponible' }}</dd>
                    </div>
                </dl>

                <div class="am-buy-box">
                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @auth
                        @if(Auth::user()->hasRole('client'))
                            @if($inStock)
                                <form method="POST" action="{{ route('panier.store') }}" class="am-buy-form">
                                    @csrf
                                    <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                    <div class="am-qty-field">
                                        <label for="quantite">Quantité</label>
                                        <div class="am-qty-control">
                                            <button type="button" class="am-qty-btn" data-am-qty="-1" aria-label="Diminuer">−</button>
                                            <input
                                                id="quantite"
                                                type="number"
                                                name="quantite"
                                                value="{{ old('quantite', 1) }}"
                                                min="1"
                                                max="{{ $produit->stock }}"
                                                required
                                            >
                                            <button type="button" class="am-qty-btn" data-am-qty="1" aria-label="Augmenter">+</button>
                                        </div>
                                    </div>
                                    <button class="btn am-btn-primary am-btn-buy" type="submit">
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6h15l-1.7 8.5a2 2 0 0 1-2 1.5H9a2 2 0 0 1-2-1.5L5 3H2m7 18h.01M18 21h.01" fill="none" stroke="currentColor" stroke-width="2"/></svg>
                                        Ajouter au panier
                                    </button>
                                    <a class="btn am-btn-ghost" href="{{ route('panier.index') }}">Voir le panier</a>
                                </form>
                            @else
                                <p class="am-buy-muted">Ce produit n'est pas disponible à l'achat pour le moment.</p>
                            @endif
                        @else
                            <p class="am-buy-muted">Connectez-vous avec un compte <strong>client</strong> pour acheter ce produit.</p>
                        @endif
                    @else
                        <a class="btn am-btn-primary am-btn-buy" href="{{ route('login') }}">Se connecter pour acheter</a>
                        @if (Route::has('register'))
                            <a class="btn am-btn-ghost" href="{{ route('register') }}">Créer un compte</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

@if(isset($related) && $related->isNotEmpty())
<section class="am-section am-related-section">
    <div class="container am-container">
        <div class="am-section-head">
            <div>
                <h2 class="am-section-title">Vous aimerez aussi</h2>
                <p class="am-section-lead">D'autres pièces de la catégorie {{ ucfirst($categoryName) }}</p>
            </div>
            <a class="am-link-arrow" href="{{ route('produits.index', ['categorie' => $categoryName]) }}">Tout voir</a>
        </div>
        @include('produits.partials.grid', ['produits' => $related])
    </div>
</section>
@endif

<script>
    document.querySelectorAll('[data-am-qty]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const input = document.getElementById('quantite');
            if (!input) return;
            const max = parseInt(input.max, 10) || 999;
            const min = parseInt(input.min, 10) || 1;
            const delta = parseInt(btn.dataset.amQty, 10);
            input.value = Math.min(max, Math.max(min, (parseInt(input.value, 10) || 1) + delta));
        });
    });
</script>
@endsection
