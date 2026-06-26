@extends('layouts.app')

@section('title', 'Commande #' . $commande->id . ' - Artisan Market')

@section('content')
@php
    $commande->load(['lignecommandes.produit.vendeur', 'paiement']);
    $total = $commande->lignecommandes->sum(fn ($l) => $l->quantite * $l->prix_unitaire);
    $canCancel = in_array($commande->statut, ['en_attente', 'en_cours'], true);
    $canPay = $commande->paiement && $commande->paiement->statut === 'en_attente' && $commande->statut === 'en_attente';
    $commandeRoutePrefix = request()->routeIs('admin.*') ? 'admin.commandes.' : 'commandes.';
@endphp

<div class="bg-[#FAF7F2] min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- Breadcrumb --}}
        <nav class="flex mb-6 text-sm font-medium text-slate-500">
            <a href="{{ route('welcome') }}" class="hover:text-[#D86513] transition">Accueil</a>
            <span class="mx-2 text-slate-400">/</span>
            <a href="{{ route($commandeRoutePrefix . 'index') }}" class="hover:text-[#D86513] transition">
                @if(request()->routeIs('admin.*'))
                    Commandes
                @else
                    Mes commandes
                @endif
            </a>
            <span class="mx-2 text-slate-400">/</span>
            <span class="text-slate-800">Commande #{{ $commande->id }}</span>
        </nav>

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Commande #{{ $commande->id }}</h1>
                    
                    @if($commande->statut === 'en_attente')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/50">
                            En attente
                        </span>
                    @elseif($commande->statut === 'en_cours')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/50">
                            En cours
                        </span>
                    @elseif($commande->statut === 'payee')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                            Payée
                        </span>
                    @elseif($commande->statut === 'annulee')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/50">
                            Annulée
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-50 text-slate-700 border border-slate-200/50">
                            {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                        </span>
                    @endif
                </div>
                <p class="text-slate-500 mt-2 text-sm">
                    Passée le {{ $commande->created_at?->format('d/m/Y \à H:i') }}
                </p>
            </div>
            
            @if(request()->routeIs('admin.*') && $commande->user)
                <div class="bg-white px-5 py-3 rounded-2xl border border-[#EFE7DD] flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-[#D86513]/10 text-[#D86513] font-bold flex items-center justify-center">
                        {{ strtoupper(substr($commande->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 font-semibold uppercase tracking-wider">Client</span>
                        <span class="text-sm font-bold text-slate-800">{{ $commande->user->name }}</span>
                    </div>
                </div>
            @endif
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            {{-- Articles Section --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl border border-[#EFE7DD] p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900 mb-6">Articles commandés</h2>
                    
                    {{-- Desktop View --}}
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-[#FAF7F2] text-slate-400 font-semibold text-xs uppercase tracking-wider pb-3">
                                    <th class="pb-3">Produit</th>
                                    <th class="pb-3 text-center">Quantité</th>
                                    <th class="pb-3 text-right">Prix Unitaire</th>
                                    <th class="pb-3 text-right">Sous-total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#FAF7F2]">
                                @foreach($commande->lignecommandes as $ligne)
                                    <tr>
                                        <td class="py-4 pr-4">
                                            <div class="flex items-center gap-4">
                                                <div class="w-16 h-16 rounded-xl border border-[#EFE7DD] bg-white overflow-hidden shrink-0 flex items-center justify-center">
                                                    @if($ligne->produit)
                                                        <img src="{{ $ligne->produit->image_url }}" alt="{{ $ligne->produit->nom }}" class="w-full h-full object-cover">
                                                    @else
                                                        <span class="text-2xl text-slate-300">📦</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    @if($ligne->produit)
                                                        <a class="font-bold text-slate-800 hover:text-[#D86513] transition text-sm sm:text-base leading-tight" href="{{ route('produits.show', $ligne->produit) }}">
                                                            {{ $ligne->produit->nom }}
                                                        </a>
                                                        @if($ligne->produit->vendeur)
                                                            <p class="text-xs text-slate-400 mt-1">
                                                                Par <span class="font-medium text-slate-600">{{ $ligne->produit->vendeur->nom_boutique ?? $ligne->produit->vendeur->user->name }}</span>
                                                            </p>
                                                        @endif
                                                    @else
                                                        <span class="font-bold text-slate-500 text-sm sm:text-base">Produit archivé (#{{ $ligne->produit_id }})</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-center font-semibold text-slate-700">
                                            {{ $ligne->quantite }}
                                        </td>
                                        <td class="py-4 px-4 text-right text-slate-600 font-medium whitespace-nowrap">
                                            {{ number_format((float) $ligne->prix_unitaire, 0, ',', ' ') }} FCFA
                                        </td>
                                        <td class="py-4 pl-4 text-right font-bold text-slate-900 whitespace-nowrap">
                                            {{ number_format((float) ($ligne->quantite * $ligne->prix_unitaire), 0, ',', ' ') }} FCFA
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile View --}}
                    <div class="sm:hidden space-y-4 divide-y divide-[#FAF7F2]">
                        @foreach($commande->lignecommandes as $index => $ligne)
                            <div class="pt-4 {{ $index === 0 ? 'pt-0' : '' }}">
                                <div class="flex gap-4">
                                    <div class="w-16 h-16 rounded-xl border border-[#EFE7DD] bg-white overflow-hidden shrink-0 flex items-center justify-center">
                                        @if($ligne->produit)
                                            <img src="{{ $ligne->produit->image_url }}" alt="{{ $ligne->produit->nom }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-2xl text-slate-300">📦</span>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        @if($ligne->produit)
                                            <a class="font-bold text-slate-800 hover:text-[#D86513] transition text-sm block truncate" href="{{ route('produits.show', $ligne->produit) }}">
                                                {{ $ligne->produit->nom }}
                                            </a>
                                            @if($ligne->produit->vendeur)
                                                <p class="text-xs text-slate-400 mt-0.5">
                                                    Par <span class="font-medium text-slate-600">{{ $ligne->produit->vendeur->nom_boutique ?? $ligne->produit->vendeur->user->name }}</span>
                                                </p>
                                            @endif
                                        @else
                                            <span class="font-bold text-slate-500 text-sm block">Produit archivé (#{{ $ligne->produit_id }})</span>
                                        @endif
                                        <div class="flex items-center justify-between mt-2">
                                            <span class="text-xs text-slate-500">x{{ $ligne->quantite }} · {{ number_format((float) $ligne->prix_unitaire, 0, ',', ' ') }} FCFA</span>
                                            <span class="text-sm font-bold text-slate-900">{{ number_format((float) ($ligne->quantite * $ligne->prix_unitaire), 0, ',', ' ') }} FCFA</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Recap Section --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-3xl border border-[#EFE7DD] p-6 shadow-sm">
                    <h2 class="text-xl font-bold text-slate-900 mb-6">Récapitulatif</h2>
                    
                    <div class="flex justify-between items-center pb-4 border-b border-[#FAF7F2] mb-6">
                        <span class="text-slate-500 font-medium">Total</span>
                        <span class="text-2xl font-black text-[#D86513]">{{ number_format((float) $total, 0, ',', ' ') }} FCFA</span>
                    </div>

                    {{-- Payment Details --}}
                    @if($commande->paiement)
                        <div class="bg-[#FAF7F2]/60 rounded-2xl border border-[#EFE7DD]/60 p-4 mb-6 space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-400">Paiement :</span>
                                <span class="font-bold text-slate-800">#{{ $commande->paiement->id }}</span>
                            </div>
                            @if($commande->paiement->numero_facture)
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Facture :</span>
                                    <span class="font-bold text-slate-800">{{ $commande->paiement->numero_facture }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-slate-400">Statut :</span>
                                @if($commande->paiement->statut === 'paye')
                                    <span class="font-bold text-emerald-600">Payé</span>
                                @elseif($commande->paiement->statut === 'en_attente')
                                    <span class="font-bold text-amber-600">En attente</span>
                                @else
                                    <span class="font-bold text-slate-600">{{ ucfirst($commande->paiement->statut) }}</span>
                                @endif
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Mode :</span>
                                <span class="font-medium text-slate-800">{{ ucfirst(str_replace('_', ' ', $commande->paiement->mode_paiement)) }}</span>
                            </div>
                        </div>
                    @endif

                    {{-- Pay Form (Client only) --}}
                    @if($canPay && Auth::user()->hasRole('client'))
                        <form method="POST" action="{{ route('paiements.pay', $commande->paiement) }}" class="space-y-4 mb-4">
                            @csrf
                            <div>
                                <label for="mode_paiement_cmd" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Choisir le mode de paiement</label>
                                <div class="relative">
                                    <select id="mode_paiement_cmd" name="mode_paiement" class="w-full h-12 rounded-xl border border-[#E7DDD1] bg-[#FAF7F2] px-4 text-sm font-medium text-slate-700 outline-none focus:ring-2 focus:ring-[#D86513] focus:border-[#D86513] appearance-none cursor-pointer" required>
                                        <option value="en_ligne" selected>💳 Paiement en ligne</option>
                                        <option value="mobile_money">📱 Mobile Money</option>
                                        <option value="carte">💳 Carte bancaire</option>
                                        <option value="virement">🏦 Virement bancaire</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="w-full h-12 rounded-xl bg-[#D86513] hover:bg-[#C45B10] text-white font-bold transition shadow-sm hover:shadow duration-200 flex items-center justify-center gap-2">
                                Payer et générer la facture
                            </button>
                        </form>
                        <a class="flex items-center justify-center w-full h-12 rounded-xl border border-[#E7DDD1] hover:border-[#D86513] hover:bg-[#D86513]/5 text-slate-700 hover:text-[#D86513] font-bold text-sm transition-all duration-200 mb-4" href="{{ route('paiements.show', $commande->paiement) }}">
                            Détail du paiement
                        </a>
                    @elseif($commande->statut === 'payee' && $commande->paiement)
                        <div class="bg-emerald-50 border border-emerald-200/60 rounded-2xl p-4 text-center text-emerald-800 font-semibold text-sm mb-4">
                            ✅ Commande payée avec succès
                        </div>
                        @if($commande->paiement->statut === 'paye' && !request()->routeIs('admin.*'))
                            <a class="flex items-center justify-center w-full h-12 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition-all shadow-sm hover:shadow duration-200 mb-4 gap-2" href="{{ route('paiements.invoice', $commande->paiement) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Télécharger la facture PDF
                            </a>
                        @endif
                    @endif

                    {{-- Actions bottom --}}
                    @if(request()->routeIs('admin.*'))
                        <form method="POST" action="{{ route('admin.commandes.destroy', $commande) }}" class="mb-4" onsubmit="return confirm('Supprimer cette commande définitivement ? Cette action est irréversible.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full h-11 rounded-xl border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 hover:text-rose-800 font-bold text-xs transition duration-200">
                                Supprimer la commande (Admin)
                            </button>
                        </form>
                    @elseif($canCancel && Auth::user()->can('delete', $commande))
                        <form method="POST" action="{{ route($commandeRoutePrefix . 'destroy', $commande) }}" class="mb-4" onsubmit="return confirm('Annuler cette commande définitivement ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full h-11 rounded-xl border border-rose-200 bg-rose-50 hover:bg-rose-100 text-rose-700 hover:text-rose-800 font-bold text-xs transition duration-200">
                                Annuler la commande
                            </button>
                        </form>
                    @endif

                    <a class="flex items-center justify-center w-full h-12 rounded-xl border border-[#E7DDD1] hover:border-slate-800 hover:bg-slate-50 text-slate-600 hover:text-slate-900 font-bold text-sm transition-all duration-200" href="{{ route('produits.index') }}">
                        Continuer mes achats
                    </a>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

