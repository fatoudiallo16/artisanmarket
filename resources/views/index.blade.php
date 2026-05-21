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

@if($latestAnnonce)
<section class="am-announcement-strip">
    <div class="container am-container d-flex flex-wrap align-items-center justify-content-between gap-3">
        <div class="d-flex flex-wrap align-items-center gap-4">
            <span class="am-pill">Actualité</span>
            <h2 class="h4 m-0 fw-bold">{{ $latestAnnonce->titre }}</h2>
        </div>
        <a class="fw-bold text-danger" href="{{ route('annonces.show', $latestAnnonce) }}">Voir plus -></a>
    </div>
</section>
@endif

<section class="am-section">
    <div class="container am-container">
        <div class="am-category-grid">
            @forelse($categories->take(3) as $categorie)
                @php
                    $name = $categorie->{$categoryColumn} ?? $categorie->nom ?? '';
                    $slug = strtolower($name);
                    $cardClass = match (true) {
                        str_contains($slug, 'bijou') => 'am-category-jewels',
                        str_contains($slug, 'tissu') => 'am-category-fabric',
                        default => 'am-category-pottery',
                    };
                @endphp
                <a href="{{ route('produits.index', ['categorie' => $name]) }}" class="am-category-card {{ $cardClass }}">
                    <h3>{{ ucfirst($name) }}</h3>
                    <p>{{ $categorie->produits_count }} produit(s)</p>
                </a>
            @empty
                <p class="text-muted">Aucune catégorie en base pour le moment.</p>
            @endforelse
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
        @include('produits.partials.grid', ['produits' => $produitsEnVedette])
    </div>
</section>

@include('partials.features-footer')
@endsection
