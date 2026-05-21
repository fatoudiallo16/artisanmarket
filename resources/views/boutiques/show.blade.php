@extends('layouts.app')

@section('title', $vendeur->nom_boutique . ' - Boutique')

@section('content')
@php($profile = $vendeur->user->vendeurProfile ?? $vendeur->profile)
<section class="am-boutique-hero">
    <div class="container am-container">
        <nav class="am-breadcrumb">
            <a href="{{ url('/') }}">Accueil</a>
            <span aria-hidden="true">/</span>
            <a href="{{ route('produits.index') }}">Catalogue</a>
            <span aria-hidden="true">/</span>
            <span aria-current="page">{{ $vendeur->nom_boutique }}</span>
        </nav>
        <div class="am-boutique-hero-grid">
            <div class="am-boutique-logo">
                @if($profile?->image_url)
                    <img src="{{ $profile->image_url }}" alt="Logo {{ $vendeur->nom_boutique }}">
                @else
                    <span class="am-boutique-logo-fallback">{{ strtoupper(substr($vendeur->nom_boutique, 0, 1)) }}</span>
                @endif
            </div>
            <div>
                <p class="am-eyebrow">Boutique artisanale</p>
                <h1 class="am-page-title">{{ $vendeur->nom_boutique }}</h1>
                <p class="am-page-lead">{{ $profile->description_boutique ?? 'Découvrez les créations artisanales de cette boutique malienne.' }}</p>
                <ul class="am-boutique-meta">
                    @if($profile?->telephone)
                        <li>Tél. {{ $profile->telephone }}</li>
                    @endif
                    @if($profile?->adresse)
                        <li>{{ $profile->adresse }}</li>
                    @endif
                    <li>{{ $produits->total() }} produit{{ $produits->total() > 1 ? 's' : '' }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container am-container">
        @include('produits.partials.grid', ['produits' => $produits])
        @if($produits->hasPages())
            <div class="am-pagination-wrap mt-4">{{ $produits->links() }}</div>
        @endif
    </div>
</section>
@endsection
