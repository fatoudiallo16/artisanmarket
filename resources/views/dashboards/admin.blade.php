@extends('layouts.app')

@section('title', 'Tableau admin - Artisan Market')

@section('content')
<section class="am-dashboard">
    <div class="container am-container">
        <div class="am-dashboard-hero mb-4">
            <p class="text-uppercase fw-bold mb-2" style="color:#f5dfb5;">Administration</p>
            <h1 class="am-section-title mb-2">Pilotage Artisan Market</h1>
            <p class="mb-0" style="max-width:760px;color:rgba(255,255,255,.82);">Validez les vendeurs, gerez les annonces et gardez la place de marche propre, vivante et lisible.</p>
        </div>

        <div class="am-dashboard-grid mb-4">
            <div class="am-stat-card"><span>Utilisateurs</span><strong>{{ $stats['users'] ?? 0 }}</strong></div>
            <div class="am-stat-card"><span>Vendeurs</span><strong>{{ $stats['vendeurs'] ?? 0 }}</strong></div>
            <div class="am-stat-card"><span>Demandes</span><strong>{{ $stats['demandes'] ?? 0 }}</strong></div>
            <div class="am-stat-card"><span>Annonces</span><strong>{{ $stats['annonces'] ?? 0 }}</strong></div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="am-panel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h3 fw-bold mb-0">Demandes vendeurs</h2>
                        <a class="fw-bold" href="{{ route('admin.vendeurs.index') }}">Tout voir</a>
                    </div>
                    <table class="am-table">
                        <thead><tr><th>Client</th><th>Boutique</th><th>Statut</th><th></th></tr></thead>
                        <tbody>
                            @forelse($recent_vendeurs ?? [] as $vendeur)
                                <tr>
                                    <td>{{ $vendeur->user->name ?? $vendeur->name }}</td>
                                    <td>{{ $vendeur->nom_boutique }}</td>
                                    <td><span class="badge text-bg-secondary">{{ $vendeur->statut }}</span></td>
                                    <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.vendeurs.show', $vendeur) }}">Ouvrir</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="4">Aucune demande pour le moment.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="am-panel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h3 fw-bold mb-0">Annonces</h2>
                        <a class="btn am-btn-primary" href="{{ route('admin.annonces.create') }}">Ajouter</a>
                    </div>
                    @forelse($recent_annonces ?? [] as $annonce)
                        <div class="border-bottom py-3">
                            <strong>{{ $annonce->titre }}</strong>
                            <div class="text-muted small">{{ optional($annonce->created_at)->format('d/m/Y') }}</div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Aucune annonce publiee.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
