@extends('layouts.app')

@section('title', 'Mes paiements - Artisan Market')

@section('content')
@php
    $paiementRoutePrefix = request()->routeIs('admin.*') ? 'admin.paiements.' : 'paiements.';
    $commandeRoutePrefix = request()->routeIs('admin.*') ? 'admin.commandes.' : 'commandes.';
@endphp
<section class="am-page-head">
    <div class="container am-container">
        <h1 class="am-page-title">Mes paiements</h1>
        <p class="am-page-lead">Historique des règlements liés à vos commandes.</p>
    </div>
</section>

<section class="pb-5">
    <div class="container am-container">
        @if($paiements->isEmpty())
            <div class="am-panel text-center py-5">
                <p class="text-muted mb-4">Aucun paiement enregistré.</p>
                <a class="btn am-btn-primary" href="{{ route($commandeRoutePrefix . 'index') }}">Voir mes commandes</a>
            </div>
        @else
            <div class="am-panel">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Commande</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Facture</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paiements as $paiement)
                                <tr>
                                    <td class="fw-bold">{{ $paiement->id }}</td>
                                    <td>#{{ $paiement->commande_id }}</td>
                                    <td>{{ number_format((float) $paiement->montant, 0, ',', ' ') }} FCFA</td>
                                    <td>
                                        <span class="badge text-bg-secondary">{{ ucfirst(str_replace('_', ' ', $paiement->statut)) }}</span>
                                    </td>
                                    <td>
                                        @if($paiement->statut === 'paye' && $paiement->numero_facture && !request()->routeIs('admin.*'))
                                            <a href="{{ route('paiements.invoice', $paiement) }}">{{ $paiement->numero_facture }}</a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>{{ $paiement->created_at?->format('d/m/Y H:i') }}</td>
                                    <td class="text-end">
                                        <a class="btn btn-sm am-btn-primary" href="{{ route($paiementRoutePrefix . 'show', $paiement) }}">Détails</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $paiements->links() }}</div>
            </div>
        @endif
    </div>
</section>
@endsection
