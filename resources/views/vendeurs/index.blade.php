@extends('layouts.app')

@section('title', 'Demandes vendeurs - Artisan Market')

@section('content')
<section class="am-dashboard">
    <div class="container am-container">
        <div class="am-dashboard-hero mb-4">
            <h1 class="am-section-title mb-2">Demandes vendeurs</h1>
            <p class="mb-0" style="color:rgba(255,255,255,.82);">Validez, suspendez ou rejetez les demandes de boutiques.</p>
        </div>

        <div class="am-panel">
            <table class="am-table">
                <thead>
                    <tr><th>Client</th><th>Boutique</th><th>Statut</th><th>Date</th><th></th></tr>
                </thead>
                <tbody>
                    @forelse($vendeurs as $vendeur)
                        <tr>
                            <td>{{ $vendeur->user->name ?? $vendeur->name }}</td>
                            <td>{{ $vendeur->nom_boutique }}</td>
                            <td><span class="badge text-bg-secondary">{{ $vendeur->statut }}</span></td>
                            <td>{{ optional($vendeur->created_at)->format('d/m/Y') }}</td>
                            <td class="text-end"><a class="btn btn-sm btn-outline-dark" href="{{ route('admin.vendeurs.show', $vendeur) }}">Examiner</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Aucune demande.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $vendeurs->links() }}</div>
        </div>
    </div>
</section>
@endsection
