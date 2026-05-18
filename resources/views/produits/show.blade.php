@extends('layouts.app')

@section('title', $produit->nom . ' - Artisan Market')

@section('content')
<section class="am-page-head">
    <div class="container am-container">
        <a class="fw-bold text-danger" href="{{ route('produits.index') }}"><- Retour au catalogue</a>
        <div class="row g-5 align-items-center mt-3">
            <div class="col-lg-6">
                <div class="am-product-media rounded overflow-hidden" style="height: 460px;">
                    <img src="{{ asset('assets/img/product/product-1.jpg') }}" alt="{{ $produit->nom }}">
                </div>
            </div>
            <div class="col-lg-6">
                <h1 class="am-page-title">{{ $produit->nom }}</h1>
                <p class="am-page-lead">{{ $produit->description ?? 'Produit artisanal sélectionné par Artisan Market.' }}</p>
                <p class="am-price fs-2">{{ number_format((float) $produit->prix, 0, ',', ' ') }} FCFA</p>
                <p class="text-muted">Stock disponible: {{ $produit->stock }}</p>
                <form method="POST" action="{{ route('panier.store') }}">
                    @csrf
                    <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                    <button class="btn am-btn-primary" type="submit">Ajouter au panier</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
