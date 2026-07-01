@extends('layouts.app')

@php
    $profile = $vendeur->profile ?? $vendeur->user?->vendeurProfile;
    $shopName = $profile?->nom_boutique ?? $vendeur->nom_boutique ?? $vendeur->name ?? 'Boutique artisanale';
    $shopDescription = $profile?->description_boutique
        ?? 'Decouvrez les creations disponibles dans cette boutique artisanale.';
    $shopImage = $profile?->image_url ?? asset('images/hero/artisan.jpg');
@endphp

@section('title', $shopName . ' | ArtisanMarket')

@section('content')
<section class="bg-[#FAF7F2] min-h-screen pb-20">
    <div class="relative h-[320px] overflow-hidden">
        <img
            src="{{ $shopImage }}"
            alt="{{ $shopName }}"
            class="w-full h-full object-cover"
        >
        <div class="absolute inset-0 bg-black/40"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4">
        <div class="relative -mt-24 z-20">
            <div class="bg-white rounded-[40px] border border-[#EEE4D8] shadow-xl p-10">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-10">
                    <div class="flex flex-col md:flex-row md:items-center gap-8">
                        <div class="w-40 h-40 rounded-[40px] overflow-hidden border-4 border-white shadow-xl shrink-0">
                            <img
                                src="{{ $shopImage }}"
                                alt="{{ $shopName }}"
                                class="w-full h-full object-cover"
                            >
                        </div>

                        <div>
                            <span class="inline-flex px-4 py-2 rounded-full bg-[#FFF1E7] text-[#D86513] font-semibold text-sm">
                                Artisan verifie
                            </span>

                            <h1 class="mt-5 text-5xl font-black text-slate-900">
                                {{ $shopName }}
                            </h1>

                            <p class="mt-5 text-lg leading-relaxed text-slate-500 max-w-2xl">
                                {{ $shopDescription }}
                            </p>

                            <div class="flex flex-wrap items-center gap-8 mt-8">
                                <div>
                                    <span class="block text-3xl font-black text-slate-900">
                                        {{ $produits->total() }}
                                    </span>
                                    <span class="text-slate-500">
                                        Produit{{ $produits->total() > 1 ? 's' : '' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a
                        href="{{ route('produits.index', ['boutique' => $vendeur->id]) }}"
                        class="h-16 px-10 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] transition text-white font-bold flex items-center justify-center"
                    >
                        Voir le catalogue
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-20">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">
                <div>
                    <h2 class="text-4xl font-black text-slate-900">
                        Produits de la boutique
                    </h2>
                    <p class="mt-4 text-slate-500">
                        Decouvrez les creations disponibles.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8">
                @forelse($produits as $produit)
                    @include('composants.cartes.carte-produits', [
                        'id' => $produit->id,
                        'title' => $produit->nom,
                        'description' => \Illuminate\Support\Str::limit($produit->description, 90),
                        'price' => number_format((float) $produit->prix, 0, ' ', ' ') . ' FCFA',
                        'category' => $produit->categorie?->name ?? 'Artisanat',
                        'badge' => $produit->stock > 0 ? 'Disponible' : null,
                        'image' => $produit->image_url,
                        'url' => route('produits.show', $produit),
                    ])
                @empty
                    <div class="sm:col-span-2 xl:col-span-4 text-center py-12 text-slate-500">
                        Aucun produit disponible dans cette boutique.
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $produits->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
