@extends('layouts.app')

@section('title', 'Commande #' . $commande->id . ' - Artisan Market')

@section('content')
@php
    $commande->load(['lignecommandes.produit', 'paiement']);
    $total = $commande->lignecommandes->sum(fn ($l) => $l->quantite * $l->prix_unitaire);
@endphp
<section class="am-page-head">
    <div class="container am-container">
        <a class="fw-bold text-danger" href="{{ route('commandes.index') }}"><- Mes commandes</a>
        <h1 class="am-page-title mt-2">Commande #{{ $commande->id }}</h1>
        <p class="am-page-lead">
            Statut :
            <span class="badge text-bg-secondary">{{ ucfirst(str_replace('_', ' ', $commande->statut)) }}</span>
            · {{ $commande->created_at?->format('d/m/Y H:i') }}
        </p>
    </div>
</section>

<section class="pb-5">
    <div class="container am-container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="am-panel">
                    <h2 class="h4 fw-bold mb-3">Articles</h2>
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th class="text-center">Qté</th>
                                    <th class="text-end">Prix unit.</th>
                                    <th class="text-end">Sous-total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commande->lignecommandes as $ligne)
                                    <tr>
                                        <td>{{ $ligne->produit?->nom ?? 'Produit #' . $ligne->produit_id }}</td>
                                        <td class="text-center">{{ $ligne->quantite }}</td>
                                        <td class="text-end">{{ number_format((float) $ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                        <td class="text-end fw-bold">
                                            {{ number_format((float) ($ligne->quantite * $ligne->prix_unitaire), 0, ',', ' ') }} FCFA
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="am-panel">
                    <h2 class="h4 fw-bold mb-3">Paiement</h2>
                    @if($commande->paiement)
                        <p class="mb-1"><strong>Montant :</strong> {{ number_format((float) $commande->paiement->montant, 0, ',', ' ') }} FCFA</p>
                        <p class="mb-1"><strong>Statut :</strong> {{ ucfirst(str_replace('_', ' ', $commande->paiement->statut)) }}</p>
                        <p class="mb-0"><strong>Mode :</strong> {{ ucfirst(str_replace('_', ' ', $commande->paiement->mode_paiement)) }}</p>
                    @else
                        <p class="text-muted mb-0">Total commande : {{ number_format((float) $total, 0, ',', ' ') }} FCFA</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
