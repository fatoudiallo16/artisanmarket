@extends('layouts.app')

@section('title', 'Mon panier - Artisan Market')

@php
    use App\Support\ProduitVisual;
    $shippingLabel = $articles->isEmpty() ? '0 FCFA' : ($total >= 50000 ? 'Offerte' : 'À confirmer');
@endphp

@section('content')
<div class="bg-[#FAF7F2] min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4">
        
        {{-- Breadcrumb --}}
        <nav class="flex mb-6 text-sm font-medium text-slate-500">
            <a href="{{ url('/') }}" class="hover:text-[#D86513] transition">Accueil</a>
            <span class="mx-2 text-slate-400">/</span>
            <span class="text-slate-800">Panier</span>
        </nav>

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                    Mon panier
                    @if(!$articles->isEmpty())
                        <span class="text-lg font-semibold text-slate-400 ml-2">({{ $articles->count() }} {{ Str::plural('article', $articles->count()) }})</span>
                    @endif
                </h1>
                <p class="text-slate-500 mt-1 text-sm md:text-base">
                    Gérez vos articles avant de finaliser votre commande.
                </p>
            </div>
        </div>

        {{-- Empty State --}}
        @if($articles->isEmpty())
            <div class="bg-white rounded-3xl border border-[#EFE7DD] p-12 text-center max-w-xl mx-auto my-8 shadow-sm">
                <div class="w-20 h-20 bg-amber-50 rounded-2xl flex items-center justify-center text-[#D86513] text-4xl mx-auto mb-6 border border-amber-100/50">
                    🛒
                </div>
                <h2 class="text-xl font-bold text-slate-900 mb-2">Votre panier est vide</h2>
                <p class="text-slate-500 mb-8 text-sm leading-relaxed max-w-md mx-auto">
                    Il semble que vous n'ayez pas encore ajouté d'articles dans votre panier. Découvrez les créations authentiques de nos artisans !
                </p>
                <a href="{{ route('produits.index') }}" class="inline-flex items-center justify-center h-12 px-8 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] text-white font-semibold shadow-sm hover:shadow transition-all duration-200">
                    Parcourir le catalogue
                </a>
            </div>
        @else
            {{-- Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                {{-- Left column (Articles) --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl border border-[#EFE7DD] p-6 shadow-sm">
                        
                        {{-- Desktop Table View --}}
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-[#FAF7F2] text-slate-400 font-semibold text-xs uppercase tracking-wider pb-3">
                                        <th class="pb-3">Produit</th>
                                        <th class="pb-3 text-center">Quantité</th>
                                        <th class="pb-3 text-right">Prix</th>
                                        <th class="pb-3 text-right">Sous-total</th>
                                        <th class="pb-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#FAF7F2]">
                                    @foreach($articles as $article)
                                        @php($produit = $article->produit)
                                        <tr class="group">
                                            <td class="py-4 pr-4">
                                                <div class="flex items-center gap-4">
                                                    <a class="w-16 h-16 rounded-xl border border-[#EFE7DD] bg-white overflow-hidden shrink-0 flex items-center justify-center transition-transform group-hover:scale-102" href="{{ route('produits.show', $produit) }}">
                                                        <img src="{{ ProduitVisual::imageUrl($produit, $loop->index) }}" alt="{{ $produit->nom }}" class="w-full h-full object-cover">
                                                    </a>
                                                    <div>
                                                        <a class="font-bold text-slate-800 hover:text-[#D86513] transition text-sm sm:text-base leading-tight block" href="{{ route('produits.show', $produit) }}">
                                                            {{ $produit->nom }}
                                                        </a>
                                                        <span class="text-xs text-slate-400 mt-1 block">
                                                            {{ $produit->categorie?->nom ?? $produit->categorie?->nom_categorie ?? 'Artisanat local' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-4 text-center">
                                                <form method="POST" action="{{ route('panier.update', $article->produit_id) }}" class="inline-flex items-center justify-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input
                                                        type="number"
                                                        name="quantite"
                                                        value="{{ $article->quantite }}"
                                                        min="1"
                                                        max="{{ $produit->stock }}"
                                                        class="w-16 h-10 border border-[#E7DDD1] bg-[#FAF7F2] rounded-xl text-center text-sm font-semibold outline-none focus:ring-2 focus:ring-[#D86513] focus:border-[#D86513]"
                                                        onchange="this.form.submit()"
                                                    >
                                                </form>
                                            </td>
                                            <td class="py-4 px-4 text-right text-slate-600 font-medium whitespace-nowrap">
                                                {{ number_format((float) $article->prix_unitaire, 0, ',', ' ') }} FCFA
                                            </td>
                                            <td class="py-4 pl-4 text-right font-bold text-slate-900 whitespace-nowrap">
                                                {{ number_format((float) ($article->quantite * $article->prix_unitaire), 0, ',', ' ') }} FCFA
                                            </td>
                                            <td class="py-4 pl-4 text-right">
                                                <form method="POST" action="{{ route('panier.destroy', $article->produit_id) }}" onsubmit="return confirm('Retirer cet article du panier ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition duration-200" title="Retirer l'article">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Mobile Stack View --}}
                        <div class="sm:hidden space-y-4 divide-y divide-[#FAF7F2]">
                            @foreach($articles as $index => $article)
                                @php($produit = $article->produit)
                                <div class="pt-4 {{ $index === 0 ? 'pt-0' : '' }}">
                                    <div class="flex gap-4">
                                        <a class="w-16 h-16 rounded-xl border border-[#EFE7DD] bg-white overflow-hidden shrink-0 flex items-center justify-center" href="{{ route('produits.show', $produit) }}">
                                            <img src="{{ ProduitVisual::imageUrl($produit, $loop->index) }}" alt="{{ $produit->nom }}" class="w-full h-full object-cover">
                                        </a>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-start gap-2">
                                                <a class="font-bold text-slate-800 hover:text-[#D86513] transition text-sm truncate" href="{{ route('produits.show', $produit) }}">
                                                    {{ $produit->nom }}
                                                </a>
                                                <form method="POST" action="{{ route('panier.destroy', $article->produit_id) }}" onsubmit="return confirm('Retirer cet article du panier ?');" class="shrink-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-1 text-slate-400 hover:text-rose-600 rounded-lg" title="Retirer l'article">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                            <span class="text-xs text-slate-400 block -mt-1 mb-2">
                                                {{ $produit->categorie?->nom ?? $produit->categorie?->nom_categorie ?? 'Artisanat local' }}
                                            </span>
                                            <div class="flex items-center justify-between mt-2">
                                                <form method="POST" action="{{ route('panier.update', $article->produit_id) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input
                                                        type="number"
                                                        name="quantite"
                                                        value="{{ $article->quantite }}"
                                                        min="1"
                                                        max="{{ $produit->stock }}"
                                                        class="w-14 h-9 border border-[#E7DDD1] bg-[#FAF7F2] rounded-lg text-center text-xs font-semibold outline-none"
                                                        onchange="this.form.submit()"
                                                    >
                                                </form>
                                                <span class="text-sm font-bold text-slate-900">{{ number_format((float) ($article->quantite * $article->prix_unitaire), 0, ',', ' ') }} FCFA</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Footer Actions --}}
                        <div class="pt-6 border-t border-[#FAF7F2] mt-6 flex justify-between items-center">
                            <form method="POST" action="{{ route('panier.clear') }}" onsubmit="return confirm('Vider tout le panier ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-400 hover:text-rose-600 transition-colors duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Vider le panier
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Right column (Summary) --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl border border-[#EFE7DD] p-6 shadow-sm space-y-6">
                        <h2 class="text-xl font-bold text-slate-900">Résumé de commande</h2>
                        
                        <div class="space-y-3 text-sm text-slate-600">
                            <div class="flex justify-between">
                                <span class="text-slate-400 font-medium">Sous-total</span>
                                <span class="font-bold text-slate-800">{{ number_format((float) $total, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400 font-medium">Livraison</span>
                                @if($shippingLabel === 'Offerte')
                                    <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded text-xs border border-emerald-100">Offerte</span>
                                @else
                                    <span class="font-bold text-slate-800">{{ $shippingLabel }}</span>
                                @endif
                            </div>
                            @if($total < 50000)
                                <p class="text-[11px] text-slate-400 leading-normal pt-1">
                                    💡 Offrez-vous la livraison gratuite en complétant vos achats jusqu'à <span class="font-semibold text-slate-500">50 000 FCFA</span> ! (Il vous manque {{ number_format((float) (50000 - $total), 0, ',', ' ') }} FCFA).
                                </p>
                            @endif
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-[#FAF7F2]">
                            <span class="text-slate-500 font-medium">Total</span>
                            <span class="text-2xl font-black text-[#D86513]">{{ number_format((float) $total, 0, ',', ' ') }} FCFA</span>
                        </div>

                        <div class="space-y-3">
                            <form method="POST" action="{{ route('panier.checkout') }}" onsubmit="return confirm('Confirmer la commande ? Le stock sera réservé.');">
                                @csrf
                                <button type="submit" class="w-full h-12 rounded-xl bg-[#D86513] hover:bg-[#C45B10] text-white font-bold transition shadow-sm hover:shadow duration-200 flex items-center justify-center gap-2" {{ $articles->isEmpty() ? 'disabled' : '' }}>
                                    Passer la commande
                                </button>
                            </form>
                            <a class="flex items-center justify-center w-full h-12 rounded-xl border border-[#E7DDD1] hover:border-slate-800 hover:bg-slate-50 text-slate-600 hover:text-slate-900 font-bold text-sm transition-all duration-200" href="{{ route('produits.index') }}">
                                Continuer mes achats
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
    </div>
</div>
@endsection

