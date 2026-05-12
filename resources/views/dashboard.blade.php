@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">
    <!-- Header Section -->
    <div class="mb-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="text-white font-weight-bold mb-2">
                    <i class="fas fa-chart-line"></i> Tableau de Bord Admin
                </h1>
                <p class="text-white-50">Bienvenue, {{ Auth::user()->name }}! 👋</p>
            </div>
            <div class="col-md-6 text-end">
                <div class="text-white">
                    <p class="mb-0" style="font-size: 0.95rem;">
                        <i class="fas fa-calendar-alt"></i> {{ now()->format('d F Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- KPI Cards Section -->
    <div class="row g-3 mb-4">
        <!-- Total Utilisateurs -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2" style="font-size: 0.9rem;">Total Utilisateurs</p>
                            <h3 class="mb-0 text-dark font-weight-bold">{{ $stats['users'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded" style="border-radius: 10px;">
                            <i class="fas fa-users text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> +12% ce mois
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Vendeurs -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2" style="font-size: 0.9rem;">Total Vendeurs</p>
                            <h3 class="mb-0 text-dark font-weight-bold">{{ $stats['vendeurs'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded" style="border-radius: 10px;">
                            <i class="fas fa-store text-success" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> +5% ce mois
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Produits -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2" style="font-size: 0.9rem;">Total Produits</p>
                            <h3 class="mb-0 text-dark font-weight-bold">{{ $stats['produits'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded" style="border-radius: 10px;">
                            <i class="fas fa-box text-warning" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-warning">
                            <i class="fas fa-arrow-down"></i> -3% ce mois
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Commandes -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2" style="font-size: 0.9rem;">Total Commandes</p>
                            <h3 class="mb-0 text-dark font-weight-bold">{{ $stats['commandes'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded" style="border-radius: 10px;">
                            <i class="fas fa-shopping-cart text-info" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> +8% ce mois
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats Row -->
    <div class="row g-3 mb-4">
        <!-- Total Paiements -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2" style="font-size: 0.9rem;">Total Paiements</p>
                            <h3 class="mb-0 text-dark font-weight-bold">{{ $stats['paiements'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-3 rounded" style="border-radius: 10px;">
                            <i class="fas fa-credit-card text-danger" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> +15% ce mois
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chiffre d'Affaires -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2" style="font-size: 0.9rem;">Chiffre d'Affaires</p>
                            <h3 class="mb-0 text-dark font-weight-bold">45,200 DH</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded" style="border-radius: 10px;">
                            <i class="fas fa-coins text-success" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> +22% ce mois
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Taux de Conversion -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2" style="font-size: 0.9rem;">Taux de Conversion</p>
                            <h3 class="mb-0 text-dark font-weight-bold">3.24%</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded" style="border-radius: 10px;">
                            <i class="fas fa-chart-pie text-info" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-danger">
                            <i class="fas fa-arrow-down"></i> -1.5% ce mois
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panier Moyen -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100 hover-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-2" style="font-size: 0.9rem;">Panier Moyen</p>
                            <h3 class="mb-0 text-dark font-weight-bold">450 DH</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded" style="border-radius: 10px;">
                            <i class="fas fa-hand-holding-usd text-warning" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-success">
                            <i class="fas fa-arrow-up"></i> +6% ce mois
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row g-4">
        <!-- Dernières Commandes -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 font-weight-bold">
                            <i class="fas fa-receipt text-primary"></i> Dernières Commandes
                        </h5>
                        <a href="{{ route('admin.commandes.index') }}" class="btn btn-sm btn-outline-primary">
                            Voir tout
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4">ID</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th class="text-end px-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_commandes ?? [] as $commande)
                                    <tr>
                                        <td class="px-4">
                                            <span class="badge bg-light text-dark">#{{ $commande->id }}</span>
                                        </td>
                                        <td>{{ $commande->user->name }}</td>
                                        <td class="fw-bold">{{ number_format($commande->total ?? 0, 2) }} DH</td>
                                        <td>
                                            @if($commande->statut === 'payee')
                                                <span class="badge bg-success">Payée</span>
                                            @elseif($commande->statut === 'en_attente')
                                                <span class="badge bg-warning">En attente</span>
                                            @elseif($commande->statut === 'annulee')
                                                <span class="badge bg-danger">Annulée</span>
                                            @else
                                                <span class="badge bg-info">{{ $commande->statut }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $commande->created_at->format('d/m/Y') }}</td>
                                        <td class="text-end px-4">
                                            <a href="{{ route('admin.commandes.show', $commande) }}" class="btn btn-sm btn-light">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            Aucune commande disponible
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Stats -->
        <div class="col-lg-4">
            <!-- Actions Rapides -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 font-weight-bold">
                        <i class="fas fa-bolt text-warning"></i> Actions Rapides
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light text-start">
                            <i class="fas fa-users me-2 text-primary"></i>
                            <span class="fw-bold">Gérer les Utilisateurs</span>
                        </a>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-light text-start">
                            <i class="fas fa-shield-alt me-2 text-success"></i>
                            <span class="fw-bold">Gérer les Rôles</span>
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-light text-start">
                            <i class="fas fa-folder me-2 text-warning"></i>
                            <span class="fw-bold">Gérer les Catégories</span>
                        </a>
                        <a href="{{ route('admin.vendeurs.index') }}" class="btn btn-light text-start">
                            <i class="fas fa-store me-2 text-info"></i>
                            <span class="fw-bold">Gérer les Vendeurs</span>
                        </a>
                        <a href="{{ route('admin.produits.index') }}" class="btn btn-light text-start">
                            <i class="fas fa-box me-2 text-danger"></i>
                            <span class="fw-bold">Gérer les Produits</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistiques d'Activité -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="card-title mb-0 font-weight-bold">
                        <i class="fas fa-activity text-success"></i> Activité
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Commandes payées</span>
                            <span class="fw-bold">85%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Produits actifs</span>
                            <span class="fw-bold">72%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-info" style="width: 72%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Vendeurs approuvés</span>
                            <span class="fw-bold">68%</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: 68%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="row g-4 mt-2">
        <!-- Derniers Vendeurs -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 font-weight-bold">
                            <i class="fas fa-user-tie text-success"></i> Derniers Vendeurs
                        </h5>
                        <a href="{{ route('admin.vendeurs.index') }}" class="btn btn-sm btn-outline-success">
                            Voir tout
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4">Nom</th>
                                    <th>Boutique</th>
                                    <th>Statut</th>
                                    <th class="text-end px-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_vendeurs ?? [] as $vendeur)
                                    <tr>
                                        <td class="px-4">{{ $vendeur->user->name }}</td>
                                        <td>{{ $vendeur->nom_boutique }}</td>
                                        <td>
                                            @if($vendeur->statut === 'approuve')
                                                <span class="badge bg-success">Approuvé</span>
                                            @elseif($vendeur->statut === 'en_attente')
                                                <span class="badge bg-warning">En attente</span>
                                            @elseif($vendeur->statut === 'suspendu')
                                                <span class="badge bg-danger">Suspendu</span>
                                            @else
                                                <span class="badge bg-info">{{ $vendeur->statut }}</span>
                                            @endif
                                        </td>
                                        <td class="text-end px-4">
                                            <a href="{{ route('admin.vendeurs.show', $vendeur) }}" class="btn btn-sm btn-light">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            Aucun vendeur disponible
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Annonces Récentes -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 font-weight-bold">
                            <i class="fas fa-newspaper text-danger"></i> Annonces Récentes
                        </h5>
                        <a href="{{ route('annonces.index') }}" class="btn btn-sm btn-outline-danger">
                            Voir tout
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4">Titre</th>
                                    <th>Auteur</th>
                                    <th>Date</th>
                                    <th class="text-end px-4">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_annonces ?? [] as $annonce)
                                    <tr>
                                        <td class="px-4">{{ \Illuminate\Support\Str::limit($annonce->titre, 30) }}</td>
                                        <td>{{ $annonce->user->name }}</td>
                                        <td>{{ $annonce->created_at->format('d/m/Y') }}</td>
                                        <td class="text-end px-4">
                                            <a href="{{ route('annonces.show', $annonce) }}" class="btn btn-sm btn-light">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            Aucune annonce disponible
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease !important;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    }

    .font-weight-bold {
        font-weight: 600;
    }

    .bg-opacity-10 {
        opacity: 0.1;
    }

    .text-white-50 {
        color: rgba(255, 255, 255, 0.5);
    }

    body {
        background-color: #f8f9fa;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    .btn-light {
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .btn-light:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    .progress {
        background-color: #e9ecef;
    }
</style>
@endsection
