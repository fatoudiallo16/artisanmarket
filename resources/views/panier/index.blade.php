@extends('layouts.app')

@section('title', 'Mon panier - Artisan Market')

@section('content')
<section class="am-page-head">
    <div class="container am-container">
        <h1 class="am-page-title">Mon panier</h1>
        <p class="am-page-lead">Vérifiez vos articles avant de passer commande.</p>
    </div>
</section>

<section class="pb-5">
    <div class="container am-container">
        @if($articles->isEmpty())
            <div class="am-panel text-center py-5">
                <p class="text-muted mb-4">Votre panier est vide.</p>
                <a class="btn am-btn-primary" href="{{ route('produits.index') }}">Parcourir le catalogue</a>
            </div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="am-panel">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-end">Prix unitaire</th>
                                        <th class="text-end">Sous-total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($articles as $article)
                                        @php($produit = $article->produit)
                                        <tr>
                                            <td>
                                                <a class="fw-bold text-decoration-none" href="{{ route('produits.show', $produit) }}">
                                                    {{ $produit->nom }}
                                                </a>
                                            </td>
                                            <td class="text-center" style="min-width: 120px;">
                                                <form method="POST" action="{{ route('panier.update', $article->produit_id) }}" class="d-inline-flex align-items-center gap-1 justify-content-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input
                                                        type="number"
                                                        name="quantite"
                                                        value="{{ $article->quantite }}"
                                                        min="1"
                                                        max="{{ $produit->stock }}"
                                                        class="form-control form-control-sm text-center"
                                                        style="width: 4rem;"
                                                        onchange="this.form.submit()"
                                                    >
                                                </form>
                                            </td>
                                            <td class="text-end">{{ number_format((float) $article->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                            <td class="text-end fw-bold">
                                                {{ number_format((float) ($article->quantite * $article->prix_unitaire), 0, ',', ' ') }} FCFA
                                            </td>
                                            <td class="text-end">
                                                <form method="POST" action="{{ route('panier.destroy', $article->produit_id) }}" onsubmit="return confirm('Retirer cet article du panier ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Retirer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <form method="POST" action="{{ route('panier.clear') }}" class="mt-3" onsubmit="return confirm('Vider tout le panier ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-secondary">Vider le panier</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="am-panel">
                        <h2 class="h4 fw-bold mb-3">Récapitulatif</h2>
                        <p class="d-flex justify-content-between mb-2">
                            <span>Articles</span>
                            <span>{{ $articles->sum('quantite') }}</span>
                        </p>
                        <p class="d-flex justify-content-between fs-5 fw-bold mb-4">
                            <span>Total</span>
                            <span class="am-price">{{ number_format((float) $total, 0, ',', ' ') }} FCFA</span>
                        </p>
                        <form method="POST" action="{{ route('panier.checkout') }}" onsubmit="return confirm('Confirmer la commande ? Le stock sera réservé.');">
                            @csrf
                            <button type="submit" class="btn am-btn-primary w-100 mb-2" {{ $articles->isEmpty() ? 'disabled' : '' }}>Passer la commande</button>
                        </form>
                        <a class="btn btn-outline-secondary w-100" href="{{ route('produits.index') }}">Continuer mes achats</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
