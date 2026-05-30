@extends('layouts.app')

@section('title', 'Paiement #' . $paiement->id . ' - Artisan Market')

@section('content')
@php
    $commande = $paiement->commande;
@endphp
<section class="am-page-head">
    <div class="container am-container">
        <a class="fw-bold text-danger" href="{{ route('paiements.index') }}"><- Mes paiements</a>
        <h1 class="am-page-title mt-2">Paiement #{{ $paiement->id }}</h1>
        <p class="am-page-lead">
            Commande #{{ $paiement->commande_id }} ·
            <span class="badge text-bg-secondary">{{ ucfirst(str_replace('_', ' ', $paiement->statut)) }}</span>
        </p>
    </div>
</section>

<section class="pb-5">
    <div class="container am-container">
        <div class="row g-4">
            <div class="col-lg-7">
                <div class="am-panel">
                    <h2 class="h4 fw-bold mb-3">Détail du règlement</h2>
                    @if($paiement->numero_facture)
                        <p class="mb-1"><strong>N° facture :</strong> {{ $paiement->numero_facture }}</p>
                    @endif
                    <p class="mb-1"><strong>Montant :</strong> {{ number_format((float) $paiement->montant, 0, ',', ' ') }} FCFA</p>
                    <p class="mb-1"><strong>Mode :</strong> {{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}</p>
                    <p class="mb-1"><strong>Date :</strong> {{ $paiement->date_paiement?->format('d/m/Y H:i') ?? $paiement->created_at?->format('d/m/Y H:i') }}</p>
                    <p class="mb-0">
                        <strong>Commande :</strong>
                        <a href="{{ route('commandes.show', $commande) }}">#{{ $commande->id }}</a>
                        ({{ ucfirst(str_replace('_', ' ', $commande->statut)) }})
                    </p>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="am-panel">
                    <h2 class="h4 fw-bold mb-3">Actions</h2>
                    @if($paiement->statut === 'en_attente' && Auth::user()->hasRole('client'))
                        <form method="POST" action="{{ route('paiements.pay', $paiement) }}" class="d-grid gap-3 mb-2">
                            @csrf
                            <div class="am-field">
                                <label for="mode_paiement">Mode de paiement</label>
                                <select id="mode_paiement" name="mode_paiement" class="form-select" required>
                                    <option value="mobile_money">Mobile Money</option>
                                    <option value="carte">Carte bancaire</option>
                                    <option value="virement">Virement</option>
                                    <option value="en_ligne">Paiement en ligne</option>
                                    <option value="especes">Espèces</option>
                                </select>
                            </div>
                            <button type="submit" class="btn am-btn-primary w-100">Confirmer et enregistrer le paiement</button>
                        </form>
                        <p class="text-muted small mb-0">Le paiement et la facture PDF seront enregistrés en base de données.</p>
                    @elseif($paiement->statut === 'paye')
                        <p class="text-success mb-3">Paiement enregistré. Merci pour votre achat.</p>
                        @if($paiement->facture_pdf || $paiement->numero_facture)
                            <a class="btn am-btn-primary w-100 mb-2" href="{{ route('paiements.invoice', $paiement) }}">
                                Télécharger la facture PDF
                            </a>
                        @endif
                    @else
                        <p class="text-muted mb-0">Aucune action disponible pour ce statut.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
