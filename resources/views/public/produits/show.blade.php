@extends('layouts.app')

@section('title', $produit->nom . ' | ArtisanMarket')

@section('content')
@php
    $categoryName = $produit->categorie?->name
        ?? $produit->categorie?->nom
        ?? $produit->categorie?->nom_categorie
        ?? 'Artisanat';
    $vendeurName = $produit->vendeur?->nom_boutique
        ?? $produit->vendeur?->name
        ?? 'Artisan';
@endphp

<section class="py-16 bg-[#FAF7F2]">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center gap-2 text-sm text-slate-500 mb-10">
            <a href="{{ route('welcome') }}" class="hover:text-[#D86513]">Accueil</a>
            <span>/</span>
            <a href="{{ route('produits.index') }}" class="hover:text-[#D86513]">Produits</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">{{ $produit->nom }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- COLONNE 1 : IMAGE ET BADGES (lg:col-span-5) -->
            <div class="lg:col-span-5">
                <div class="relative bg-white rounded-[32px] overflow-hidden border border-[#EEE4D8] shadow-sm aspect-[4/5]">
                    <!-- Image -->
                    <img
                        src="{{ $produit->image_url }}"
                        alt="{{ $produit->nom }}"
                        class="w-full h-full object-cover"
                    >
                    <!-- Badge Nouveau -->
                    <span class="absolute top-4 left-4 bg-[#D86513] text-white text-xs font-black uppercase tracking-wider px-3.5 py-2 rounded-xl shadow-md">
                        Nouveau
                    </span>
                    <!-- Zoom Button -->
                    <button class="absolute top-4 right-4 bg-white/95 backdrop-blur hover:bg-white text-slate-800 p-3 rounded-full shadow-lg transition flex items-center justify-center hover:scale-105">
                        <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Galerie / Vignettes simulées -->
                <div class="grid grid-cols-4 gap-3 mt-4">
                    <div class="border-2 border-[#D86513] rounded-xl overflow-hidden cursor-pointer aspect-square bg-white flex items-center justify-center p-1">
                        <img src="{{ $produit->image_url }}" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="border border-[#EEE4D8] opacity-60 hover:opacity-100 transition rounded-xl overflow-hidden cursor-pointer aspect-square bg-white flex items-center justify-center p-1">
                        <img src="{{ $produit->image_url }}" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="border border-[#EEE4D8] opacity-60 hover:opacity-100 transition rounded-xl overflow-hidden cursor-pointer aspect-square bg-white flex items-center justify-center p-1">
                        <img src="{{ $produit->image_url }}" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div class="border border-[#EEE4D8] opacity-60 hover:opacity-100 transition rounded-xl overflow-hidden cursor-pointer aspect-square bg-white flex items-center justify-center p-1">
                        <img src="{{ $produit->image_url }}" class="w-full h-full object-cover rounded-lg">
                    </div>
                </div>
            </div>

            <!-- COLONNE 2 : INFOS PRODUIT (lg:col-span-4) -->
            <div class="lg:col-span-4">
                @if($produit->categorie)
                    <a
                        href="{{ route('produits.categorie', $produit->categorie) }}"
                        class="inline-flex px-3.5 py-1.5 rounded-full bg-[#FFF1E7] text-[#D86513] font-bold text-xs uppercase tracking-wider"
                    >
                        {{ $categoryName }}
                    </a>
                @else
                    <span class="inline-flex px-3.5 py-1.5 rounded-full bg-[#FFF1E7] text-[#D86513] font-bold text-xs uppercase tracking-wider">
                        {{ $categoryName }}
                    </span>
                @endif

                <h1 class="mt-4 text-3xl font-black text-slate-900 leading-tight">
                    {{ $produit->nom }}
                </h1>

                <!-- Avis / Etoiles fictifs -->
                <div class="flex items-center gap-2 mt-3">
                    <div class="flex text-amber-500">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="text-xs text-slate-500 font-bold">(24 avis)</span>
                </div>

                <div class="mt-6">
                    <span class="text-3xl font-black text-[#D86513]">
                        {{ number_format((float) $produit->prix, 0, ' ', ' ') }} FCFA
                    </span>
                </div>

                <div class="mt-4 flex items-center gap-3 text-xs">
                    <span class="inline-flex items-center gap-1.5 font-bold text-green-700 bg-green-50 px-2.5 py-1 rounded-md border border-green-200">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        {{ $produit->stock > 0 ? 'En stock' : 'Indisponible' }}
                    </span>
                    <span class="text-slate-300">|</span>
                    <span class="text-slate-500 font-semibold">{{ $produit->stock }} pièces disponibles</span>
                </div>

                @if($produit->description)
                    <p class="mt-6 text-sm leading-relaxed text-slate-600">
                        {{ $produit->description }}
                    </p>
                @endif

                <!-- Liste d'attributs clés fictifs pour la forme -->
                <div class="mt-8 border-t border-[#EEE4D8] pt-6 space-y-3.5">
                    <div class="flex items-center text-xs">
                        <span class="w-28 text-slate-500 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Catégorie :
                        </span>
                        <span class="font-bold text-slate-800">{{ ucfirst($categoryName) }}</span>
                    </div>
                    <div class="flex items-center text-xs">
                        <span class="w-28 text-slate-500 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                            Matière :
                        </span>
                        <span class="font-bold text-slate-800">Perles, Bois, Coton</span>
                    </div>
                    <div class="flex items-center text-xs">
                        <span class="w-28 text-slate-500 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                            Couleur :
                        </span>
                        <span class="font-bold text-slate-800">Marron, Noir, Beige</span>
                    </div>
                    <div class="flex items-center text-xs">
                        <span class="w-28 text-slate-500 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
                            Longueur :
                        </span>
                        <span class="font-bold text-slate-800">45 cm</span>
                    </div>
                    <div class="flex items-center text-xs">
                        <span class="w-28 text-slate-500 flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                            Poids :
                        </span>
                        <span class="font-bold text-slate-800">120 g</span>
                    </div>
                </div>

                @auth
                    <form method="POST" action="{{ route('panier.store') }}" class="mt-8">
                        @csrf
                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">

                        <label class="font-bold text-slate-900 mb-3 block text-sm" for="quantite">
                            Quantité :
                        </label>

                        <!-- Sélecteur de quantité stylisé avec AlpineJS -->
                        <div x-data="{ quantite: 1, maxStock: {{ max(1, (int) $produit->stock) }} }" class="flex items-center gap-4">
                            <div class="flex items-center border border-[#E7DDD1] bg-white rounded-2xl overflow-hidden h-14">
                                <button
                                    type="button"
                                    @click="if (quantite > 1) quantite--"
                                    class="w-12 h-full text-slate-600 hover:bg-slate-50 font-bold transition flex items-center justify-center text-xl select-none"
                                >
                                    −
                                </button>
                                <input
                                    id="quantite"
                                    type="number"
                                    name="quantite"
                                    x-model.number="quantite"
                                    @change="if (quantite < 1) quantite = 1; if (quantite > maxStock) quantite = maxStock;"
                                    class="w-12 h-full text-center font-bold text-slate-800 border-none outline-none focus:ring-0"
                                >
                                <button
                                    type="button"
                                    @click="if (quantite < maxStock) quantite++"
                                    class="w-12 h-full text-slate-600 hover:bg-slate-50 font-bold transition flex items-center justify-center text-xl select-none"
                                >
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="mt-6 flex gap-4">
                            <button
                                type="submit"
                                class="flex-1 h-14 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] transition text-white font-bold text-md shadow-lg shadow-orange-200 disabled:opacity-50 flex items-center justify-center gap-2"
                                {{ $produit->stock <= 0 ? 'disabled' : '' }}
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Ajouter au panier
                            </button>

                            <a
                                href="{{ route('favoris.index') }}"
                                class="w-14 h-14 rounded-2xl border border-[#E7DDD1] bg-white hover:border-red-500 hover:text-red-500 transition flex items-center justify-center text-slate-500"
                                title="Ajouter aux favoris"
                            >
                                <svg class="w-5 h-5 fill-none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </a>
                        </div>
                    </form>
                @else
                    <div class="mt-8 rounded-2xl border border-[#E7DDD1] bg-white p-5 text-sm">
                        <p class="text-slate-600 mb-4">
                            Connectez-vous pour ajouter ce produit à votre panier.
                        </p>
                        <div class="flex gap-4">
                            <a
                                href="{{ route('login', ['redirect' => url()->current()]) }}"
                                class="flex-1 h-12 rounded-xl bg-[#D86513] hover:bg-[#C45B10] transition text-white font-bold flex items-center justify-center"
                            >
                                Se connecter
                            </a>
                            <a
                                href="{{ route('register') }}"
                                class="flex-1 h-12 rounded-xl border border-[#E7DDD1] hover:border-[#D86513] hover:text-[#D86513] transition flex items-center justify-center font-semibold"
                            >
                                Créer un compte
                            </a>
                        </div>
                    </div>
                @endauth
            </div>

            <!-- COLONNE 3 : VENDEUR & LIVRAISON (lg:col-span-3) -->
            <div class="lg:col-span-3 space-y-6">
                @if($produit->vendeur)
                    <!-- Carte Vendeur -->
                    <div class="bg-white rounded-[24px] border border-[#EEE4D8] p-6 shadow-sm">
                        <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest">
                            Vendeur
                        </h4>
                        
                        <div class="flex items-center gap-3.5 mt-5">
                            <!-- Avatar Initiales -->
                            <div class="w-12 h-12 rounded-full bg-[#FFF1E7] text-[#D86513] flex items-center justify-center font-black text-lg shadow-inner">
                                {{ strtoupper(substr($vendeurName, 0, 1)) }}
                            </div>
                            
                            <div>
                                <h3 class="font-black text-slate-800 text-sm flex items-center gap-1.5">
                                    {{ $vendeurName }}
                                    <svg class="w-4 h-4 text-orange-500 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                    </svg>
                                </h3>
                                <p class="text-slate-400 text-[10px] font-medium mt-0.5">
                                    Artisan professionnel
                                </p>
                                <div class="flex items-center gap-1 mt-1">
                                    <span class="text-amber-500 text-xs">★</span>
                                    <span class="text-slate-600 text-xs font-bold">4.8</span>
                                    <span class="text-slate-400 text-[10px]">(56 avis)</span>
                                </div>
                            </div>
                        </div>

                        <a
                            href="{{ route('boutiques.show', $produit->vendeur) }}"
                            class="mt-6 w-full h-11 rounded-xl border border-[#D86513] text-[#D86513] hover:bg-[#D86513] hover:text-white transition font-bold text-xs flex items-center justify-center"
                        >
                            Voir la boutique
                        </a>

                        <!-- Métriques Vendeur -->
                        <div class="mt-6 pt-5 border-t border-slate-100 space-y-4 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-400 font-medium">Produits :</span>
                                <span class="font-bold text-slate-700">{{ $produit->vendeur->produits()->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400 font-medium">Ventes :</span>
                                <span class="font-bold text-slate-700">342</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400 font-medium">Membre depuis :</span>
                                <span class="font-bold text-slate-700">{{ $produit->vendeur->created_at ? $produit->vendeur->created_at->translatedFormat('M Y') : 'Mars 2026' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400 font-medium">Répond en moyenne :</span>
                                <span class="font-bold text-slate-700">2h</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Carte Livraison -->
                <div class="bg-white rounded-[24px] border border-[#EEE4D8] p-6 shadow-sm space-y-4 text-xs">
                    <h4 class="font-black text-slate-800 text-sm">
                        Informations de livraison
                    </h4>
                    <div class="space-y-3 pt-2">
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h2m-4-3h9M3 13h18M5 17h14M7 21h10"></path></svg>
                            <div>
                                <p class="font-bold text-slate-700">Livraison internationale</p>
                                <p class="text-slate-400 mt-0.5">Disponible partout au Mali et à l'étranger.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <p class="font-bold text-slate-700">Expédition rapide</p>
                                <p class="text-slate-400 mt-0.5">Expédié en 24h à 48h jours ouvrés.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($related->isNotEmpty())
            <div class="mt-20">
                <div class="flex items-end justify-between gap-6 mb-8">
                    <h2 class="text-3xl font-black text-slate-900">Produits similaires</h2>
                    <a href="{{ route('produits.index') }}" class="text-[#D86513] font-semibold">Voir tout</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($related as $item)
                        @include('composants.cartes.carte-produits', [
                            'title' => $item->nom,
                            'description' => \Illuminate\Support\Str::limit($item->description, 90),
                            'price' => number_format((float) $item->prix, 0, ' ', ' ') . ' FCFA',
                            'category' => $item->categorie?->name ?? 'Artisanat',
                            'badge' => $item->stock > 0 ? 'Disponible' : null,
                            'image' => $item->image_url,
                            'url' => route('produits.show', $item),
                        ])
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
