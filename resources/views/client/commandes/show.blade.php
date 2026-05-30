@extends('layouts.app')

@section('title', 'Commande #' . $commande->id . ' - Artisan Market')

@section('content')
@php
    $commande->load(['lignecommandes.produit', 'paiement']);
    $total = $commande->lignecommandes->sum(fn ($l) => $l->quantite * $l->prix_unitaire);
    $canCancel = in_array($commande->statut, ['en_attente', 'en_cours'], true);
    $canPay = $commande->paiement && $commande->paiement->statut === 'en_attente' && $commande->statut === 'en_attente';
    $commandeRoutePrefix = request()->routeIs('admin.*') ? 'admin.commandes.' : 'commandes.';
@endphp
<section class="am-page-head">
    <div class="container am-container">
        <a class="fw-bold text-danger" href="{{ route($commandeRoutePrefix . 'index') }}"><- Mes commandes</a>
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
                    <h2 class="h4 fw-bold mb-3">Articles commandés</h2>
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
                                        <td>
                                            @if($ligne->produit)
                                                <a class="fw-bold text-decoration-none" href="{{ route('produits.show', $ligne->produit) }}">
                                                    {{ $ligne->produit->nom }}
                                                </a>
                                            @else
                                                Produit #{{ $ligne->produit_id }}
                                            @endif
                                        </td>
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
                <div class="am-panel mb-3">
                    <h2 class="h4 fw-bold mb-3">Récapitulatif</h2>
                    <p class="d-flex justify-content-between fs-5 fw-bold mb-3">
                        <span>Total</span>
                        <span class="am-price">{{ number_format((float) $total, 0, ',', ' ') }} FCFA</span>
                    </p>

                    @if($commande->paiement)
                        <p class="mb-1"><strong>Paiement :</strong> #{{ $commande->paiement->id }}</p>
                        @if($commande->paiement->numero_facture)
                            <p class="mb-1"><strong>Facture :</strong> {{ $commande->paiement->numero_facture }}</p>
                        @endif
                        <p class="mb-1"><strong>Statut :</strong> {{ ucfirst(str_replace('_', ' ', $commande->paiement->statut)) }}</p>
                        <p class="mb-3"><strong>Mode :</strong> {{ ucfirst(str_replace('_', ' ', $commande->paiement->mode_paiement)) }}</p>
                    @endif

                    @if($canPay && Auth::user()->hasRole('client'))
                        <form method="POST" action="{{ route('paiements.pay', $commande->paiement) }}" class="d-grid gap-2 mb-2">
                            @csrf
                            <div class="am-field">
                                <label for="mode_paiement_cmd">Mode de paiement</label>
                                <select id="mode_paiement_cmd" name="mode_paiement" class="form-select" required>
                                    <option value="mobile_money">Mobile Money</option>
                                    <option value="carte">Carte bancaire</option>
                                    <option value="virement">Virement</option>
                                    <option value="en_ligne" selected>Paiement en ligne</option>
                                </select>
                            </div>
                            <button type="submit" class="btn am-btn-primary w-100">Payer et générer la facture</button>
                        </form>
                        <a class="btn btn-outline-secondary w-100 mb-2" href="{{ route('paiements.show', $commande->paiement) }}">Détail du paiement</a>
                    @elseif($commande->statut === 'payee' && $commande->paiement)
                        <p class="text-success mb-2">Commande payée et enregistrée en base.</p>
                        @if($commande->paiement->statut === 'paye' && !request()->routeIs('admin.*'))
                            <a class="btn am-btn-primary w-100 mb-2" href="{{ route('paiements.invoice', $commande->paiement) }}">
                                Télécharger la facture PDF
                            </a>
                        @endif
                    @endif

                    @if($canCancel && Auth::user()->can('delete', $commande))
                        <form method="POST" action="{{ route($commandeRoutePrefix . 'destroy', $commande) }}" class="mt-3" onsubmit="return confirm('Annuler cette commande ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">Annuler la commande</button>
                        </form>
                    @endif
                </div>
                <a class="btn btn-outline-secondary w-100" href="{{ route('produits.index') }}">Continuer mes achats</a>
            </div>
        </div>
    </div>
</section>
@endsection
