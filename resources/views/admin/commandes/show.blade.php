@extends('layouts.admin')

@section('title', 'Commande #' . $commande->id . ' — Admin')

@section('content')
@php
    $commande->load(['lignecommandes.produit.vendeur', 'paiement', 'user']);
    $total = $commande->lignecommandes->sum(fn($l) => $l->quantite * $l->prix_unitaire);
    $statutStr = (string) $commande->statut;
    [$statusColor, $statusLabel] = match($statutStr) {
        'payee'      => ['bg-emerald-100 text-emerald-800', 'Payée'],
        'en_cours'   => ['bg-blue-100 text-blue-800',       'En cours'],
        'en_attente' => ['bg-amber-100 text-amber-800',     'En attente'],
        'annulee'    => ['bg-rose-100 text-rose-800',       'Annulée'],
        default      => ['bg-slate-100 text-slate-700',     ucfirst($statutStr)],
    };
@endphp

<div class="space-y-6 animate-fade-in">

    {{-- Breadcrumb & Header --}}
    <div class="border-b border-slate-200 pb-5">
        <nav class="flex items-center gap-2 text-sm text-slate-400 mb-3">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 transition">Tableau de bord</a>
            <span>/</span>
            <a href="{{ route('admin.commandes.index') }}" class="hover:text-amber-600 transition">Commandes</a>
            <span>/</span>
            <span class="text-slate-700 font-semibold">#{{ $commande->id }}</span>
        </nav>
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4 flex-wrap">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    Commande <span class="text-amber-600">#{{ $commande->id }}</span>
                </h1>
                <span class="inline-flex px-3 py-1 rounded-full text-sm font-bold {{ $statusColor }}">
                    {{ $statusLabel }}
                </span>
            </div>
            <p class="text-sm text-slate-400">Passée le {{ $commande->created_at?->format('d/m/Y à H:i') }}</p>
        </div>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3">
            <span>✅</span><p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- Articles --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100">
                    <h2 class="text-lg font-bold text-slate-800">📦 Articles commandés</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="text-xs font-semibold text-slate-400 uppercase bg-slate-50/50 border-b border-slate-100">
                                <th class="px-6 py-3">Produit</th>
                                <th class="px-6 py-3 text-center">Qté</th>
                                <th class="px-6 py-3 text-right">Prix unitaire</th>
                                <th class="px-6 py-3 text-right">Sous-total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($commande->lignecommandes as $ligne)
                                <tr class="hover:bg-slate-50/30 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl border border-slate-100 overflow-hidden shrink-0 flex items-center justify-center bg-slate-50">
                                                @if($ligne->produit)
                                                    <img src="{{ $ligne->produit->image_url }}" alt="{{ $ligne->produit->nom }}" class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-xl text-slate-300">📦</span>
                                                @endif
                                            </div>
                                            <div>
                                                @if($ligne->produit)
                                                    <a href="{{ route('produits.show', $ligne->produit) }}"
                                                       class="font-semibold text-slate-800 hover:text-amber-600 transition">
                                                        {{ $ligne->produit->nom }}
                                                    </a>
                                                    @if($ligne->produit->vendeur)
                                                        <p class="text-xs text-slate-400">
                                                            Par {{ $ligne->produit->vendeur->nom_boutique ?? $ligne->produit->vendeur->name }}
                                                        </p>
                                                    @endif
                                                @else
                                                    <span class="text-slate-400 italic">Produit archivé (#{{ $ligne->produit_id }})</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-semibold text-slate-700">{{ $ligne->quantite }}</td>
                                    <td class="px-6 py-4 text-right text-slate-600 whitespace-nowrap">{{ number_format((float)$ligne->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-900 whitespace-nowrap">{{ number_format((float)($ligne->quantite * $ligne->prix_unitaire), 0, ',', ' ') }} FCFA</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-slate-200 bg-slate-50/50">
                                <td colspan="3" class="px-6 py-4 text-right font-bold text-slate-700">Total</td>
                                <td class="px-6 py-4 text-right font-extrabold text-amber-600 text-lg whitespace-nowrap">
                                    {{ number_format((float)$total, 0, ',', ' ') }} FCFA
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- Infos client --}}
            @if($commande->user)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">👤 Client</h2>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-700 font-black flex items-center justify-center text-lg">
                            {{ strtoupper(substr($commande->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">{{ $commande->user->name }}</p>
                            <p class="text-sm text-slate-400">{{ $commande->user->email }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Panneau actions --}}
        <div class="space-y-4">

            {{-- Récapitulatif paiement --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">💳 Paiement</h2>
                @if($commande->paiement)
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Référence :</span>
                            <span class="font-semibold text-slate-800">#{{ $commande->paiement->id }}</span>
                        </div>
                        @if($commande->paiement->numero_facture)
                            <div class="flex justify-between">
                                <span class="text-slate-400">Facture :</span>
                                <span class="font-semibold text-slate-800">{{ $commande->paiement->numero_facture }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-slate-400">Montant :</span>
                            <span class="font-bold text-slate-900">{{ number_format((float)$commande->paiement->montant, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Mode :</span>
                            <span class="font-medium text-slate-800">{{ ucfirst(str_replace('_', ' ', $commande->paiement->mode_paiement)) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Statut :</span>
                            @php $ps = (string) $commande->paiement->statut; @endphp
                            <span class="font-bold {{ $ps === 'paye' ? 'text-emerald-600' : ($ps === 'en_attente' ? 'text-amber-600' : 'text-slate-600') }}">
                                {{ match($ps) { 'paye' => 'Payé', 'en_attente' => 'En attente', 'echoue' => 'Échoué', 'rembourse' => 'Remboursé', default => ucfirst($ps) } }}
                            </span>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-slate-400 italic">Aucun paiement associé.</p>
                @endif
            </div>

            {{-- Changement de statut --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">⚙️ Modifier le statut</h2>
                <form method="POST" action="{{ route('admin.commandes.update', $commande) }}" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <select name="statut"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-amber-400 transition">
                        <option value="en_attente" {{ $statutStr === 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
                        <option value="en_cours"   {{ $statutStr === 'en_cours'   ? 'selected' : '' }}>🔄 En cours</option>
                        <option value="payee"      {{ $statutStr === 'payee'      ? 'selected' : '' }}>✅ Payée</option>
                        <option value="annulee"    {{ $statutStr === 'annulee'    ? 'selected' : '' }}>❌ Annulée</option>
                    </select>
                    <button type="submit"
                            class="w-full h-10 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm transition shadow-sm">
                        Mettre à jour
                    </button>
                </form>
            </div>

            {{-- Suppression --}}
            <form method="POST" action="{{ route('admin.commandes.destroy', $commande) }}"
                  onsubmit="return confirm('Supprimer définitivement la commande #{{ $commande->id }} ? Cette action est irréversible.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full h-10 rounded-xl border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-sm transition">
                    🗑 Supprimer la commande
                </button>
            </form>

            {{-- Retour --}}
            <a href="{{ route('admin.commandes.index') }}"
               class="flex items-center justify-center w-full h-10 rounded-xl border border-slate-200 bg-white hover:border-amber-300 hover:text-amber-700 text-slate-600 font-semibold text-sm transition">
                ← Retour à la liste
            </a>
        </div>
    </div>

</div>
@endsection
