@extends('layouts.app')

@section('title', 'Artisan Market - Artisanat malien')

@php
    use App\Support\ProduitVisual;

    $categoryImages = ProduitVisual::productImages();
@endphp

@section('content')
<section class="am-hero am-home-hero">
    <div class="container am-container am-hero-inner">
        <button class="am-hero-control am-hero-control--prev" type="button" aria-label="Image précédente">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
        </button>
        <div class="am-hero-content">
            <h1>L'artisanat local dans toute sa <span>beauté</span></h1>
            <p class="mt-4">Découvrez des créations uniques, faites avec passion par nos artisans talentueux.</p>
            <div class="d-flex flex-wrap gap-3 mt-5">
                <a class="btn am-btn-primary" href="{{ route('produits.index') }}">Découvrir la collection</a>
                <a class="btn am-btn-ghost am-btn-ghost--hero" href="{{ route('annonces.index') }}">En savoir plus</a>
            </div>
        </div>
        <div class="am-hero-dots" aria-hidden="true">
            <span class="active"></span>
            <span></span>
            <span></span>
        </div>
        <button class="am-hero-control am-hero-control--next" type="button" aria-label="Image suivante">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
        </button>
    </div>
</section>

<section class="am-service-strip" aria-label="Services Artisan Market">
    <div class="container am-container">
        <div class="am-service-grid">
            <div class="am-service-item">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h11v10H3zM14 11h3l3 3v3h-6zM7 20h.01M17 20h.01"/></svg>
                <div><strong>Livraison rapide</strong><span>Partout au Mali</span></div>
            </div>
            <div class="am-service-item">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10V7a5 5 0 0 1 10 0v3M5 10h14v10H5z"/></svg>
                <div><strong>Paiement sécurisé</strong><span>100% sécurisé</span></div>
            </div>
            <div class="am-service-item">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 4 8v5c0 4.5 3.2 7.6 8 8 4.8-.4 8-3.5 8-8V8zM8.5 12.5l2.2 2.2 4.8-5"/></svg>
                <div><strong>Produits artisanaux</strong><span>Faits main avec amour</span></div>
            </div>
            <div class="am-service-item">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 12a8 8 0 0 1 16 0v4a2 2 0 0 1-2 2h-2v-6h4M4 16a2 2 0 0 0 2 2h2v-6H4"/></svg>
                <div><strong>Support 24/7</strong><span>Nous sommes là</span></div>
            </div>
        </div>
    </div>
</section>

@if($latestAnnonce)
<section class="am-announcement-strip">
    <div class="container am-container d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex flex-wrap align-items-center gap-4">
            <span class="am-pill">Actualité</span>
            <h2 class="h4 m-0 fw-bold">{{ $latestAnnonce->titre }}</h2>
        </div>
    </div>
</section>
@endif

<section class="am-section am-section--categories">
    <div class="container am-container">
        <div class="am-section-head">
            <div>
                <h2 class="am-section-title">Nos catégories</h2>
            </div>
            <a class="am-link-arrow" href="{{ route('produits.index') }}">Voir toutes les catégories</a>
        </div>

        <div class="am-category-grid am-category-grid--home">
            @forelse($categories->take(6) as $categorie)
                @php
                    $name = $categorie->name ?? '';
                    $preview = $categoryImages[$loop->index % count($categoryImages)];
                @endphp
                <a href="{{ route('produits.index', ['categorie' => $name]) }}" class="am-category-tile">
                    <span class="am-category-thumb">
                        <img src="{{ $preview }}" alt="">
                    </span>
                    <strong>{{ ucfirst($name) }}</strong>
                    <p>{{ $categorie->produits_count }} produit{{ $categorie->produits_count > 1 ? 's' : '' }}</p>
                </a>
            @empty
                <p class="text-muted">Aucune catégorie en base pour le moment.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="am-section pt-0">
    <div class="container am-container">
        <div class="am-section-head">
            <div>
                <h2 class="am-section-title">Nos produits populaires</h2>
            </div>
            <a class="am-link-arrow" href="{{ route('produits.index') }}">Voir tous les produits</a>
        </div>
        @include('public.produits.partials.grid', ['produits' => $produitsEnVedette, 'gridClass' => 'am-product-grid--featured'])
    </div>
</section>

<section class="am-section pt-0" id="a-propos">
    <div class="container am-container">
        <div class="am-promo-grid">
            <article class="am-promo-card am-promo-card--dark">
                <div>
                    <h2>Soutenez nos artisans</h2>
                    <p>Chaque achat contribue à préserver notre patrimoine et à soutenir des familles et des communautés.</p>
                    <a class="btn am-btn-light" href="{{ route('produits.index') }}">En savoir plus</a>
                </div>
            </article>
            <article class="am-promo-card am-promo-card--light">
                <div>
                    <h2>Livraison offerte</h2>
                    <p>À partir de 50 000 FCFA sur une sélection de pièces disponibles.</p>
                    <a class="btn am-btn-primary" href="{{ route('produits.index') }}">Découvrir</a>
                </div>
            </article>
        </div>
    </div>
</section>

<section class="am-section pt-0">
    <div class="container am-container">
        <div class="am-section-head">
            <div>
                <h2 class="am-section-title">Nouveautés</h2>
            </div>
            <a class="am-link-arrow" href="{{ route('produits.index', ['sort' => 'nouveautes']) }}">Voir toutes les nouveautés</a>
        </div>
        @include('public.produits.partials.grid', ['produits' => $produitsEnVedette, 'gridClass' => 'am-product-grid--featured'])
    </div>
</section>
@endsection
