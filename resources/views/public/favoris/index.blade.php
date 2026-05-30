@extends('layouts.app')

@section('title', 'Favoris | ArtisanMarket')

@section('content')

    {{-- FAVORIS --}}
    <section class="py-16 bg-[#FAF7F2] min-h-screen">

        <div class="max-w-7xl mx-auto px-4">

            {{-- HEADER --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-14">

                <div>

                    {{-- BREADCRUMB --}}
                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-4">

                        <a href="{{ route('welcome') }}" class="hover:text-[#D86513]">
                            Accueil
                        </a>

                        <span>/</span>

                        <span class="text-slate-900 font-medium">
                            Favoris
                        </span>

                    </div>

                    {{-- TITLE --}}
                    <h1 class="text-5xl font-black text-slate-900">

                        Mes Favoris

                    </h1>

                    <p class="mt-4 text-lg text-slate-500">

                        Retrouvez les produits que vous aimez.

                    </p>

                </div>

                {{-- COUNT --}}
                <div class="bg-white border border-[#EEE4D8] rounded-3xl px-8 py-5">

                    <span class="text-slate-500">
                        Produits favoris :
                    </span>

                    <span class="text-2xl font-black text-[#D86513] ml-2">
                        6
                    </span>

                </div>

            </div>

            {{-- GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">

                {{-- PRODUCT --}}
                <div class="relative">

                    {{-- REMOVE --}}
                    <button
                        class="absolute top-5 right-5 z-20 w-12 h-12 rounded-2xl bg-white shadow-lg hover:bg-red-500 hover:text-white transition flex items-center justify-center"
                    >
                        ✕
                    </button>

                    @include('composants.cartes.carte-produits', [
                        'title' => 'Sac artisanal premium',
                        'description' => 'Sac confectionné à la main avec des matériaux locaux.',
                        'price' => '18 000 FCFA',
                        'category' => 'Mode',
                        'badge' => 'Favori',
                        'image' => asset('images/produits/sac.jpg')
                    ])

                </div>

                {{-- PRODUCT --}}
                <div class="relative">

                    <button
                        class="absolute top-5 right-5 z-20 w-12 h-12 rounded-2xl bg-white shadow-lg hover:bg-red-500 hover:text-white transition flex items-center justify-center"
                    >
                        ✕
                    </button>

                    @include('composants.cartes.carte-produits', [
                        'title' => 'Panier tressé africain',
                        'description' => 'Panier décoratif fait main.',
                        'price' => '12 000 FCFA',
                        'category' => 'Décoration',
                        'badge' => 'Populaire',
                        'image' => asset('images/produits/panier.jpg')
                    ])

                </div>

                {{-- PRODUCT --}}
                <div class="relative">

                    <button
                        class="absolute top-5 right-5 z-20 w-12 h-12 rounded-2xl bg-white shadow-lg hover:bg-red-500 hover:text-white transition flex items-center justify-center"
                    >
                        ✕
                    </button>

                    @include('composants.cartes.carte-produits', [
                        'title' => 'Bijou artisanal',
                        'description' => 'Bijou moderne inspiré de l’art africain.',
                        'price' => '9 500 FCFA',
                        'category' => 'Bijoux',
                        'badge' => 'Best Seller',
                        'image' => asset('images/produits/bijou.jpg')
                    ])

                </div>

            </div>

            {{-- EMPTY STATE --}}
            {{-- 
            <div class="bg-white rounded-[40px] border border-[#EEE4D8] py-24 px-10 text-center">

                <div class="text-7xl mb-8">
                    ♡
                </div>

                <h2 class="text-4xl font-black text-slate-900">

                    Aucun favori

                </h2>

                <p class="mt-6 text-lg text-slate-500 max-w-xl mx-auto">

                    Vous n’avez encore ajouté aucun produit à vos favoris.

                </p>

                <a
                    href="{{ route('produits.index') }}"
                    class="inline-flex items-center justify-center mt-10 h-14 px-10 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] transition text-white font-bold"
                >
                    Découvrir les produits
                </a>

            </div>
            --}}

        </div>

    </section>

@endsection
