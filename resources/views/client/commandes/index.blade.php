@extends('layouts.app')

@section('title', 'Mes commandes - Artisan Market')

@section('content')
@php($commandeRoutePrefix = request()->routeIs('admin.*') ? 'admin.commandes.' : 'commandes.')
@php($commandes->loadMissing(['lignecommandes', 'user']))

<div class="bg-[#FAF7F2] min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- Breadcrumb --}}
        <nav class="flex mb-6 text-sm font-medium text-slate-500">
            <a href="{{ route('welcome') }}" class="hover:text-[#D86513] transition">Accueil</a>
            <span class="mx-2 text-slate-400">/</span>
            @if(request()->routeIs('admin.*'))
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#D86513] transition">Admin</a>
                <span class="mx-2 text-slate-400">/</span>
                <span class="text-slate-800">Commandes</span>
            @else
                <a href="{{ route('client.dashboard') }}" class="hover:text-[#D86513] transition">Mon espace</a>
                <span class="mx-2 text-slate-400">/</span>
                <span class="text-slate-800">Mes commandes</span>
            @endif
        </nav>

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                    @if(request()->routeIs('admin.*'))
                        Gestion des commandes
                    @else
                        Mes commandes
                    @endif
                </h1>
                <p class="text-slate-500 mt-1 text-sm md:text-base">
                    @if(request()->routeIs('admin.*'))
                        Consultez et gérez l'ensemble des commandes passées sur la plateforme.
                    @else
                        Historique et suivi en temps réel de vos achats.
                    @endif
                </p>
            </div>
        </div>

        {{-- Empty State --}}
        @if($commandes->isEmpty())
            <div class="bg-white rounded-3xl border border-[#EFE7DD] p-12 text-center max-w-xl mx-auto my-8 shadow-sm">
                <div class="w-20 h-20 bg-amber-50 rounded-2xl flex items-center justify-center text-[#D86513] text-4xl mx-auto mb-6 border border-amber-100/50">
                    🛍️
                </div>
                <h2 class="text-xl font-bold text-slate-900 mb-2">Aucune commande trouvée</h2>
                <p class="text-slate-500 mb-8 text-sm leading-relaxed max-w-md mx-auto">
                    @if(request()->routeIs('admin.*'))
                        Aucune commande n'a encore été enregistrée sur le système.
                    @else
                        Vous n'avez pas encore passé de commande. Découvrez les créations uniques de nos artisans locaux !
                    @endif
                </p>
                @if(!request()->routeIs('admin.*'))
                    <a href="{{ route('produits.index') }}" class="inline-flex items-center justify-center h-12 px-8 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] text-white font-semibold shadow-sm hover:shadow transition-all duration-200">
                        Découvrir les produits
                    </a>
                @endif
            </div>
        @else
            {{-- Desktop Table View --}}
            <div class="hidden md:block bg-white rounded-3xl border border-[#EFE7DD] shadow-sm overflow-hidden mb-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[#FAF7F2] bg-[#FAF7F2]/50 text-slate-500 font-semibold text-xs uppercase tracking-wider">
                                <th class="py-4 px-6">Référence</th>
                                <th class="py-4 px-6">Date de commande</th>
                                @if(request()->routeIs('admin.*'))
                                    <th class="py-4 px-6">Client</th>
                                @endif
                                <th class="py-4 px-6">Articles</th>
                                <th class="py-4 px-6">Montant total</th>
                                <th class="py-4 px-6">Statut</th>
                                <th class="py-4 px-6 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#FAF7F2] text-sm">
                            @foreach($commandes as $commande)
                                @php
                                    $itemsCount = $commande->lignecommandes->sum('quantite');
                                    $totalAmount = $commande->lignecommandes->sum(fn ($l) => $l->quantite * $l->prix_unitaire);
                                @endphp
                                <tr class="hover:bg-[#FAF7F2]/40 transition-colors duration-150">
                                    <td class="py-4 px-6 font-bold text-[#D86513]">
                                        #{{ $commande->id }}
                                    </td>
                                    <td class="py-4 px-6 text-slate-600">
                                        {{ $commande->created_at?->format('d/m/Y H:i') }}
                                    </td>
                                    @if(request()->routeIs('admin.*'))
                                        <td class="py-4 px-6 text-slate-700 font-medium">
                                            {{ $commande->user?->name ?? 'Client inconnu' }}
                                        </td>
                                    @endif
                                    <td class="py-4 px-6 text-slate-500">
                                        {{ $itemsCount }} {{ Str::plural('article', $itemsCount) }}
                                    </td>
                                    <td class="py-4 px-6 font-bold text-slate-900">
                                        {{ number_format((float) $totalAmount, 0, ',', ' ') }} FCFA
                                    </td>
                                    <td class="py-4 px-6">
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
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <a href="{{ route($commandeRoutePrefix . 'show', $commande) }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl border border-[#E7DDD1] hover:border-[#D86513] hover:bg-[#D86513]/5 text-slate-700 hover:text-[#D86513] font-bold text-xs transition duration-200">
                                            Détails
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Mobile Card View --}}
            <div class="grid grid-cols-1 gap-4 md:hidden mb-6">
                @foreach($commandes as $commande)
                    @php
                        $itemsCount = $commande->lignecommandes->sum('quantite');
                        $totalAmount = $commande->lignecommandes->sum(fn ($l) => $l->quantite * $l->prix_unitaire);
                    @endphp
                    <div class="bg-white rounded-2xl border border-[#EFE7DD] p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-bold text-[#D86513] text-base">#{{ $commande->id }}</span>
                            @if($commande->statut === 'en_attente')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/50">
                                    En attente
                                </span>
                            @elseif($commande->statut === 'en_cours')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/50">
                                    En cours
                                </span>
                            @elseif($commande->statut === 'payee')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                    Payée
                                </span>
                            @elseif($commande->statut === 'annulee')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/50">
                                    Annulée
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-50 text-slate-700 border border-slate-200/50">
                                    {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                </span>
                            @endif
                        </div>
                        
                        <div class="space-y-2 mb-4 text-sm text-slate-600">
                            <div class="flex justify-between">
                                <span class="text-slate-400">Date :</span>
                                <span class="font-medium text-slate-800">{{ $commande->created_at?->format('d/m/Y H:i') }}</span>
                            </div>
                            @if(request()->routeIs('admin.*'))
                                <div class="flex justify-between">
                                    <span class="text-slate-400">Client :</span>
                                    <span class="font-medium text-slate-800">{{ $commande->user?->name ?? 'Client inconnu' }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-slate-400">Articles :</span>
                                <span class="font-medium text-slate-800">{{ $itemsCount }} {{ Str::plural('article', $itemsCount) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400">Total :</span>
                                <span class="font-bold text-slate-900">{{ number_format((float) $totalAmount, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>
                        
                        <div class="pt-3 border-t border-[#FAF7F2]">
                            <a href="{{ route($commandeRoutePrefix . 'show', $commande) }}" class="flex items-center justify-center w-full h-11 rounded-xl bg-[#FAF7F2] hover:bg-[#D86513]/10 text-slate-700 hover:text-[#D86513] font-bold text-sm transition-all duration-200">
                                Détails de la commande
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center mt-8">
                {{ $commandes->links() }}
            </div>
        @endif
        
    </div>
</div>
@endsection

