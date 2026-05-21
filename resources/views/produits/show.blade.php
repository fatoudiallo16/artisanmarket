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
                <p class="text-muted mb-3">
                    @if($produit->stock > 0)
                        En stock : {{ $produit->stock }} unité(s)
                    @else
                        <span class="text-danger fw-bold">Rupture de stock</span>
                    @endif
                </p>

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
                        @if($produit->stock > 0)
                            <form method="POST" action="{{ route('panier.store') }}" class="d-flex flex-wrap align-items-end gap-3">
                                @csrf
                                <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                                <div class="am-field">
                                    <label for="quantite">Quantité</label>
                                    <input
                                        id="quantite"
                                        type="number"
                                        name="quantite"
                                        value="{{ old('quantite', 1) }}"
                                        min="1"
                                        max="{{ $produit->stock }}"
                                        class="form-control"
                                        style="max-width: 6rem;"
                                        required
                                    >
                                </div>
                                <button class="btn am-btn-primary" type="submit">Ajouter au panier</button>
                                <a class="btn btn-outline-secondary" href="{{ route('panier.index') }}">Voir le panier</a>
                            </form>
                        @else
                            <p class="text-muted">Ce produit n'est pas disponible à l'achat pour le moment.</p>
                        @endif
                    @else
                        <p class="text-muted">Connectez-vous avec un compte <strong>client</strong> pour acheter ce produit.</p>
                    @endif
                @else
                    <a class="btn am-btn-primary" href="{{ route('login') }}">Se connecter pour acheter</a>
                    @if (Route::has('register'))
                        <a class="btn btn-outline-secondary ms-2" href="{{ route('register') }}">Créer un compte</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</section>
@endsection
