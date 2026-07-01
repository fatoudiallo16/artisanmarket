@extends('layouts.admin')

@section('title', 'Tableau de bord Administrateur')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Tableau de bord
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Vue d'ensemble de l'activité d'Artisan Market en temps réel.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                Système opérationnel
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3">
            <span>✅</span>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Users Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-slate-400 group-hover:text-amber-600 transition-colors">Utilisateurs</span>
                <span class="text-2xl p-2 bg-amber-50 rounded-xl">👥</span>
            </div>
            <div class="flex items-baseline gap-2 mt-4">
                <h2 class="text-3xl font-bold text-slate-800">{{ $usersCount }}</h2>
                <span class="text-xs text-slate-400 font-medium">au total</span>
            </div>
        </div>

        <!-- Sellers Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-slate-400 group-hover:text-amber-600 transition-colors">Vendeurs</span>
                <span class="text-2xl p-2 bg-amber-50 rounded-xl">🏪</span>
            </div>
            <div class="flex items-baseline justify-between mt-4">
                <div class="flex items-baseline gap-2">
                    <h2 class="text-3xl font-bold text-slate-800">{{ $sellersCount }}</h2>
                </div>
                @if($stats['demandes'] > 0)
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 animate-bounce">
                        {{ $stats['demandes'] }} en attente
                    </span>
                @endif
            </div>
        </div>

        <!-- Products Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-slate-400 group-hover:text-amber-600 transition-colors">Produits</span>
                <span class="text-2xl p-2 bg-amber-50 rounded-xl">📦</span>
            </div>
            <div class="flex items-baseline justify-between mt-4">
                <div class="flex items-baseline gap-2">
                    <h2 class="text-3xl font-bold text-slate-800">{{ $productsCount }}</h2>
                </div>
                <span class="text-xs text-slate-400 font-medium">{{ $categoriesCount }} catégories</span>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all duration-200 group">
            <div class="flex items-center justify-between">
                                                                                      <span class="text-sm font-medium text-slate-400 group-hover:text-amber-600 transition-colors">Commandes</span>
                <span class="text-2xl p-2 bg-amber-50 rounded-xl">🛒</span>
            </div>
            <div class="flex items-baseline gap-2 mt-4">
                <h2 class="text-3xl font-bold text-slate-800">{{ $ordersCount }}</h2>
                <span class="text-xs text-slate-400 font-medium">enregistrées</span>
            </div>
        </div>
    </div>

    <!-- Pending Vendor Requests -->
    @php
        $pendingSellers = $recent_vendeurs->where('statut', 'en_attente');
    @endphp

    @if($pendingSellers->count() > 0)
        <div class="bg-white rounded-2xl border border-amber-200 shadow-sm overflow-hidden">
            <div class="px-6 py-5 bg-amber-50 border-b border-amber-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-amber-900 flex items-center gap-2">
                    <span>🔔</span> Demandes de vendeurs en attente
                </h3>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-200 text-amber-900">
                    {{ $pendingSellers->count() }} nouvelle(s) demande(s)
                </span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs font-semibold text-slate-400 uppercase bg-slate-50/50">
                            <th class="px-6 py-4">Artisan</th>
                            <th class="px-6 py-4">Nom Boutique</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Date de Demande</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @foreach($pendingSellers as $vendeur)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-slate-800">
                                    {{ $vendeur->name }}
                                </td>
                                <td class="px-6 py-4 italic text-slate-700">
                                    {{ $vendeur->nom_boutique }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $vendeur->user->email ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-slate-400">
                                    {{ $vendeur->created_at ? $vendeur->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                                    <form action="{{ route('admin.vendeurs.update', $vendeur) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="statut" value="approuve">
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-500 hover:bg-emerald-600 text-white transition">
                                            Approuver
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.vendeurs.update', $vendeur) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="statut" value="rejete">
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold bg-rose-500 hover:bg-rose-600 text-white transition">
                                            Rejeter
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Recent Orders Section -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-800">
                🛒 Commandes Récentes
            </h3>
            <a href="{{ route('admin.commandes.index') }}" class="text-sm font-semibold text-amber-600 hover:text-amber-700 transition">
                Voir toutes les commandes →
            </a>
        </div>
        <div class="overflow-x-auto">
            @if($recent_commandes->count() > 0)
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs font-semibold text-slate-400 uppercase bg-slate-50/50">
                            <th class="px-6 py-4">Commande</th>
                            <th class="px-6 py-4">Client</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-right">Détails</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                        @foreach($recent_commandes as $commande)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-800">
                                    #{{ $commande->id }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $commande->user->name ?? 'Client Inconnu' }}
                                </td>
                                <td class="px-6 py-4 text-slate-400">
                                    {{ $commande->created_at ? $commande->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusClass = match($commande->statut) {
                                            'payee' => 'bg-emerald-100 text-emerald-800',
                                            'en_cours' => 'bg-blue-100 text-blue-800',
                                            'en_attente' => 'bg-amber-100 text-amber-800',
                                            'annulee' => 'bg-rose-100 text-rose-800',
                                            default => 'bg-slate-100 text-slate-800',
                                        };
                                        $statusLabel = match($commande->statut) {
                                            'payee' => 'Payée',
                                            'en_cours' => 'En cours',
                                            'en_attente' => 'En attente',
                                            'annulee' => 'Annulée',
                                            default => $commande->statut,
                                        };
                                    @endphp
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.commandes.show', $commande) }}" class="inline-flex items-center justify-center p-1.5 bg-slate-50 hover:bg-amber-50 hover:text-amber-700 rounded-lg text-slate-400 transition">
                                        👁️
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-8 text-center text-slate-400">
                    Aucune commande enregistrée pour le moment.
                </div>
            @endif
        </div>
    </div>

    <!-- Double Grid layout for payments and announcements -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Payments -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-800">
                    💳 Paiements Récents
                </h3>
            </div>
            <div class="p-6">
                @if($recent_paiements->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_paiements as $paiement)
                            <div class="flex items-center justify-between p-4 rounded-xl border border-slate-50 bg-slate-50/50 hover:bg-slate-50 transition">
                                <div class="flex items-center gap-3">
                                    <span class="text-xl">💰</span>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">Commande #{{ $paiement->commande_id }}</p>
                                        <p class="text-xs text-slate-400">{{ $paiement->created_at ? $paiement->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-slate-900">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</p>
                                    <span class="text-xs font-semibold text-emerald-600">Succès</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center text-slate-400">
                        Aucun paiement enregistré.
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Announcements -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-slate-800">
                    📢 Annonces & Promos
                </h3>
            </div>
            <div class="p-6">
                @if($recent_annonces->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_annonces as $annonce)
                            <div class="p-4 rounded-xl border border-slate-50 bg-slate-50/50 hover:bg-slate-50 transition">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-sm font-bold text-slate-800">
                                        {{ $annonce->titre }}
                                    </h4>
                                    <span class="text-xs text-slate-400">
                                        {{ $annonce->created_at ? $annonce->created_at->format('d/m/Y') : 'N/A' }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-2">
                                    {{ $annonce->contenu }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-8 text-center text-slate-400">
                        Aucune annonce publiée.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection