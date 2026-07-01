@extends('layouts.admin')

@section('title', 'Gestion des commandes — Admin')

@section('content')

<div class="space-y-6 animate-fade-in">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 border-b border-slate-200 pb-5">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                🛒 Commandes
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Gérez l'ensemble des commandes passées sur la plateforme.
            </p>
        </div>
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-slate-200 bg-white hover:border-amber-300 hover:text-amber-700 text-slate-600 text-sm font-semibold transition">
            ← Retour au tableau de bord
        </a>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-3">
            <span>✅</span>
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center gap-3">
            <span>❌</span>
            <p class="font-medium">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Stats rapides --}}
    @php
        $allItems   = $commandes->getCollection();
        $nbPayees   = $allItems->filter(fn($c) => (string) $c->statut === 'payee')->count();
        $nbAttente  = $allItems->filter(fn($c) => (string) $c->statut === 'en_attente')->count();
        $nbAnnulees = $allItems->filter(fn($c) => (string) $c->statut === 'annulee')->count();
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Total</p>
            <p class="text-2xl font-black text-slate-800 mt-1">{{ $commandes->total() }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-xs font-semibold text-emerald-500 uppercase tracking-wide">Payées</p>
            <p class="text-2xl font-black text-emerald-700 mt-1">{{ $nbPayees }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-xs font-semibold text-amber-500 uppercase tracking-wide">En attente</p>
            <p class="text-2xl font-black text-amber-700 mt-1">{{ $nbAttente }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <p class="text-xs font-semibold text-rose-400 uppercase tracking-wide">Annulées</p>
            <p class="text-2xl font-black text-rose-600 mt-1">{{ $nbAnnulees }}</p>
        </div>
    </div>

    @if($commandes->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-12 text-center">
            <p class="text-5xl mb-4">🛒</p>
            <p class="text-slate-500 font-medium">Aucune commande enregistrée pour le moment.</p>
        </div>
    @else
        {{-- Table desktop --}}
        <div class="hidden md:block bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs font-semibold text-slate-400 uppercase bg-slate-50/50">
                            <th class="px-6 py-4">#</th>
                            <th class="px-6 py-4">Client</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Montant</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm text-slate-700">
                        @foreach($commandes as $commande)
                            @php
                                $commande->loadMissing(['lignecommandes', 'user']);
                                $montant = $commande->lignecommandes->sum(fn($l) => $l->quantite * $l->prix_unitaire);
                                $statutStr = (string) $commande->statut;
                                $statusColor = match($statutStr) {
                                    'payee'      => 'bg-emerald-100 text-emerald-800',
                                    'en_cours'   => 'bg-blue-100 text-blue-800',
                                    'en_attente' => 'bg-amber-100 text-amber-800',
                                    'annulee'    => 'bg-rose-100 text-rose-800',
                                    default      => 'bg-slate-100 text-slate-700',
                                };
                                $statusLabel = match($statutStr) {
                                    'payee'      => 'Payée',
                                    'en_cours'   => 'En cours',
                                    'en_attente' => 'En attente',
                                    'annulee'    => 'Annulée',
                                    default      => ucfirst($statutStr),
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-amber-600">#{{ $commande->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 font-bold flex items-center justify-center text-xs shrink-0">
                                            {{ strtoupper(substr($commande->user?->name ?? 'X', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $commande->user?->name ?? 'Client inconnu' }}</p>
                                            <p class="text-xs text-slate-400">{{ $commande->user?->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-slate-400 whitespace-nowrap">
                                    {{ $commande->created_at?->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-900 whitespace-nowrap">
                                    {{ number_format((float) $montant, 0, ',', ' ') }} FCFA
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusColor }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.commandes.show', $commande) }}"
                                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-200 bg-white hover:border-amber-300 hover:text-amber-700 text-slate-600 text-xs font-semibold transition">
                                            👁 Voir
                                        </a>
                                        {{-- Changement de statut rapide --}}
                                        <form method="POST" action="{{ route('admin.commandes.update', $commande) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="statut" onchange="this.form.submit()"
                                                    class="text-xs rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-slate-600 cursor-pointer focus:outline-none focus:ring-1 focus:ring-amber-400 transition">
                                                <option value="en_attente" {{ $statutStr === 'en_attente' ? 'selected' : '' }}>En attente</option>
                                                <option value="en_cours"   {{ $statutStr === 'en_cours'   ? 'selected' : '' }}>En cours</option>
                                                <option value="payee"      {{ $statutStr === 'payee'      ? 'selected' : '' }}>Payée</option>
                                                <option value="annulee"    {{ $statutStr === 'annulee'    ? 'selected' : '' }}>Annulée</option>
                                            </select>
                                        </form>
                                        <form method="POST" action="{{ route('admin.commandes.destroy', $commande) }}" class="inline"
                                              onsubmit="return confirm('Supprimer définitivement la commande #{{ $commande->id }} ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1.5 rounded-lg border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 text-xs font-semibold transition">
                                                🗑
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Cartes mobile --}}
        <div class="md:hidden space-y-4">
            @foreach($commandes as $commande)
                @php
                    $commande->loadMissing(['lignecommandes', 'user']);
                    $montant = $commande->lignecommandes->sum(fn($l) => $l->quantite * $l->prix_unitaire);
                    $statutStr = (string) $commande->statut;
                    $statusColor = match($statutStr) {
                        'payee'      => 'bg-emerald-100 text-emerald-800',
                        'en_cours'   => 'bg-blue-100 text-blue-800',
                        'en_attente' => 'bg-amber-100 text-amber-800',
                        'annulee'    => 'bg-rose-100 text-rose-800',
                        default      => 'bg-slate-100 text-slate-700',
                    };
                    $statusLabel = match($statutStr) {
                        'payee' => 'Payée', 'en_cours' => 'En cours',
                        'en_attente' => 'En attente', 'annulee' => 'Annulée',
                        default => ucfirst($statutStr),
                    };
                @endphp
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-bold text-amber-600">#{{ $commande->id }}</span>
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusColor }}">{{ $statusLabel }}</span>
                    </div>
                    <p class="text-sm font-semibold text-slate-800">{{ $commande->user?->name ?? 'Client inconnu' }}</p>
                    <p class="text-xs text-slate-400 mb-1">{{ $commande->user?->email }}</p>
                    <p class="text-xs text-slate-400 mb-3">{{ $commande->created_at?->format('d/m/Y H:i') }}</p>
                    <p class="text-lg font-black text-slate-900 mb-4">{{ number_format((float) $montant, 0, ',', ' ') }} FCFA</p>
                    <a href="{{ route('admin.commandes.show', $commande) }}"
                       class="flex items-center justify-center w-full h-10 rounded-xl border border-amber-200 bg-amber-50 text-amber-800 font-semibold text-sm hover:bg-amber-100 transition">
                        Voir le détail
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="flex justify-center mt-4">
            {{ $commandes->links() }}
        </div>
    @endif

</div>
@endsection
