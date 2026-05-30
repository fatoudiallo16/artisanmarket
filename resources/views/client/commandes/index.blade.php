@extends('layouts.app')

@section('title', 'Mes commandes - Artisan Market')

@section('content')
@php($commandeRoutePrefix = request()->routeIs('admin.*') ? 'admin.commandes.' : 'commandes.')
<section class="am-page-head">
    <div class="container am-container">
        <h1 class="am-page-title">Mes commandes</h1>
        <p class="am-page-lead">Historique et suivi de vos achats.</p>
    </div>
</section>

<section class="pb-5">
    <div class="container am-container">
        @if($commandes->isEmpty())
            <div class="am-panel text-center py-5">
                <p class="text-muted mb-4">Vous n'avez pas encore de commande.</p>
                <a class="btn am-btn-primary" href="{{ route('produits.index') }}">Voir le catalogue</a>
            </div>
        @else
            <div class="am-panel">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Statut</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commandes as $commande)
                                <tr>
                                    <td class="fw-bold">{{ $commande->id }}</td>
                                    <td>{{ $commande->created_at?->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge text-bg-secondary">{{ ucfirst(str_replace('_', ' ', $commande->statut)) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a class="btn btn-sm am-btn-primary" href="{{ route($commandeRoutePrefix . 'show', $commande) }}">Détails</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">{{ $commandes->links() }}</div>
            </div>
        @endif
    </div>
</section>
@endsection
