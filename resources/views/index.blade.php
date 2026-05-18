@extends('layouts.app')

@section('title', 'Artisan Market - Artisanat malien')

@section('content')
<section class="am-hero">
    <div class="container am-container am-hero-inner">
        <div>
            <h1>Découvrez l'Artisanat Malien Authentique</h1>
            <p class="mt-4">Bijoux, tissus et poteries faits main par des artisans passionnés, sélectionnés pour leur caractère, leur qualité et leur histoire.</p>
            <div class="d-flex flex-wrap gap-3 mt-5">
                <a class="btn am-btn-light" href="{{ route('produits.index') }}">Voir le catalogue</a>
                <a class="btn am-btn-outline" href="{{ route('annonces.index') }}">Les annonces</a>
            </div>
        </div>
    </div>
</section>

<section class="am-announcement-strip">
    <div class="container am-container d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex flex-wrap align-items-center gap-4">
            <span class="am-pill">Actualité</span>
            <h2 class="h4 m-0 fw-bold">Nouvelle collection de tissus Bogolan</h2>
        </div>
        <a class="fw-bold text-danger" href="{{ route('annonces.index') }}">Voir plus -></a>
    </div>
</section>

<section class="am-section">
    <div class="container am-container">
        <div class="am-category-grid">
            <a href="{{ route('produits.index', ['categorie' => 'bijoux']) }}" class="am-category-card am-category-jewels">
                <svg class="am-category-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linejoin="round" aria-hidden="true"><path d="M12 2 4 6.5v9L12 20l8-4.5v-9L12 2Z"/><path d="m4 6.5 8 4.5 8-4.5M12 11v9"/></svg>
                <h3>Bijoux</h3>
                <p>Colliers, bracelets et boucles d'oreilles</p>
            </a>
            <a href="{{ route('produits.index', ['categorie' => 'tissus']) }}" class="am-category-card am-category-fabric">
                <svg class="am-category-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16v16H4z"/><path d="M4 9h16M9 4v16"/></svg>
                <h3>Tissus</h3>
                <p>Bazin, bogolan et tissus traditionnels</p>
            </a>
            <a href="{{ route('produits.index', ['categorie' => 'poterie']) }}" class="am-category-card am-category-pottery">
                <svg class="am-category-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linejoin="round" aria-hidden="true"><path d="M8 3h8l-1 5 3 5a5 5 0 0 1-4.5 8h-3A5 5 0 0 1 6 13l3-5-1-5Z"/><path d="M8.5 8h7"/></svg>
                <h3>Poterie</h3>
                <p>Vases, pots et céramiques artisanales</p>
            </a>
        </div>
    </div>
</section>

<section class="am-section pt-0">
    <div class="container am-container">
        <div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
            <div>
                <h2 class="am-section-title mb-2">Produits en Vedette</h2>
                <p class="am-page-lead m-0">Découvrez notre sélection de produits d'exception</p>
            </div>
            <a class="fw-bold text-danger" href="{{ route('produits.index') }}">Tout voir -></a>
        </div>
        @include('produits.partials.grid', ['produits' => collect()])
    </div>
</section>

@include('partials.features-footer')
@endsection
