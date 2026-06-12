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

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-start">
            <div>
                <div class="bg-white rounded-[40px] overflow-hidden border border-[#EEE4D8] shadow-sm">
                    <img
                        src="{{ $produit->image_url }}"
                        alt="{{ $produit->nom }}"
                        class="w-full h-[520px] object-cover"
                    >
                </div>
            </div>

            <div>
                @if($produit->categorie)
                    <a
                        href="{{ route('produits.categorie', $produit->categorie) }}"
                        class="inline-flex px-4 py-2 rounded-full bg-[#FFF1E7] text-[#D86513] font-semibold text-sm"
                    >
                        {{ ucfirst($categoryName) }}
                    </a>
                @else
                    <span class="inline-flex px-4 py-2 rounded-full bg-[#FFF1E7] text-[#D86513] font-semibold text-sm">
                        {{ ucfirst($categoryName) }}
                    </span>
                @endif

                <h1 class="mt-6 text-5xl font-black text-slate-900 leading-tight">
                    {{ $produit->nom }}
                </h1>

                <div class="mt-8">
                    <span class="text-5xl font-black text-slate-900">
                        {{ number_format((float) $produit->prix, 0, ' ', ' ') }} FCFA
                    </span>
                </div>

                @if($produit->description)
                    <p class="mt-8 text-lg leading-relaxed text-slate-600">
                        {{ $produit->description }}
                    </p>
                @endif

                <div class="mt-8 flex items-center gap-3">
                    <span class="w-3 h-3 rounded-full {{ $produit->stock > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                    <span class="font-medium text-slate-700">
                        {{ $produit->stock > 0 ? 'En stock' : 'Indisponible' }}
                    </span>
                </div>

                @auth
                    <form method="POST" action="{{ route('panier.store') }}" class="mt-10">
                        @csrf
                        <input type="hidden" name="produit_id" value="{{ $produit->id }}">

                        <label class="font-bold text-slate-900 mb-4 block" for="quantite">
                            Quantite
                        </label>

                        <input
                            id="quantite"
                            type="number"
                            name="quantite"
                            value="1"
                            min="1"
                            max="{{ max(1, (int) $produit->stock) }}"
                            class="w-32 h-14 rounded-2xl border border-[#E7DDD1] bg-white px-4 font-bold"
                        >

                        <div class="mt-8 flex flex-col sm:flex-row gap-5">
                            <button
                                type="submit"
                                class="flex-1 h-16 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] transition text-white font-bold text-lg shadow-lg shadow-orange-200 disabled:opacity-50"
                                {{ $produit->stock <= 0 ? 'disabled' : '' }}
                            >
                                Ajouter au panier
                            </button>

                            <a
                                href="{{ route('produits.index') }}"
                                class="h-16 px-8 rounded-2xl border border-[#E7DDD1] bg-white hover:border-[#D86513] hover:text-[#D86513] transition flex items-center justify-center font-semibold"
                            >
                                Continuer mes achats
                            </a>
                        </div>
                    </form>
                @else
                    <div class="mt-10 rounded-2xl border border-[#E7DDD1] bg-white p-6">
                        <p class="text-slate-600 mb-4">
                            Connectez-vous pour ajouter ce produit à votre panier.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a
                                href="{{ route('login', ['redirect' => url()->current()]) }}"
                                class="h-14 px-8 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] transition text-white font-bold flex items-center justify-center"
                            >
                                Se connecter
                            </a>
                            <a
                                href="{{ route('register') }}"
                                class="h-14 px-8 rounded-2xl border border-[#E7DDD1] hover:border-[#D86513] hover:text-[#D86513] transition flex items-center justify-center font-semibold"
                            >
                                Créer un compte
                            </a>
                        </div>
                    </div>
                @endauth

                @if($produit->vendeur)
                    <div class="mt-14 bg-white rounded-[32px] border border-[#EEE4D8] p-8">
                        <h3 class="text-2xl font-bold text-slate-900">
                            {{ $vendeurName }}
                        </h3>
                        <p class="mt-2 text-slate-500">
                            Artisan verifie
                        </p>

                        <a
                            href="{{ route('boutiques.show', $produit->vendeur) }}"
                            class="mt-8 w-full h-14 rounded-2xl border border-[#D86513] text-[#D86513] hover:bg-[#D86513] hover:text-white transition font-semibold flex items-center justify-center"
                        >
                            Voir la boutique
                        </a>
                    </div>
                @endif
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
