@extends('layouts.app')

@section('title', 'Produits | ArtisanMarket')

@section('content')

    {{-- PAGE HEADER --}}
    <section class="bg-white border-b border-[#EEE4D8]">

        <div class="max-w-7xl mx-auto px-4 py-12">

            {{-- BREADCRUMB --}}
            <div class="flex items-center gap-2 text-sm text-slate-500 mb-4">

                <a href="{{ route('welcome') }}" class="hover:text-[#D86513]">
                    Accueil
                </a>

                <span>/</span>

                <span class="text-slate-900 font-medium">
                    Produits
                </span>

            </div>

            {{-- TITLE --}}
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                <div>

                    <h1 class="text-5xl font-black text-slate-900">

                        Nos Produits

                    </h1>

                    <p class="mt-4 text-lg text-slate-500 max-w-2xl">

                        Découvrez une sélection de créations artisanales authentiques réalisées par des artisans locaux.

                    </p>

                </div>

                {{-- SEARCH --}}
                <div class="relative max-w-md w-full">

                    <input
                        type="text"
                        placeholder="Rechercher un produit..."
                        class="w-full h-14 rounded-2xl border border-[#E7DDD1] bg-[#FAF7F2] pl-5 pr-14 outline-none focus:ring-2 focus:ring-[#D86513]"
                    >

                    <button
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-[#D86513]"
                    >
                        🔍
                    </button>

                </div>

            </div>

        </div>

    </section>

    {{-- CONTENT --}}
    <section class="py-16 bg-[#FAF7F2]">

        <div class="max-w-7xl mx-auto px-4">

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">

                {{-- SIDEBAR --}}
                <aside class="lg:col-span-1">

                    <div class="bg-white rounded-[32px] p-8 border border-[#EEE4D8] sticky top-28">

                        {{-- TITLE --}}
                        <h2 class="text-2xl font-black text-slate-900 mb-8">

                            Filtres

                        </h2>

                        {{-- CATEGORIES --}}
                        <div class="mb-10">

                            <h3 class="font-bold text-slate-900 mb-5">
                                Catégories
                            </h3>

                            <div class="space-y-4">

                                <label class="flex items-center gap-3">

                                    <input type="checkbox">

                                    <span class="text-slate-600">
                                        Mode
                                    </span>

                                </label>

                                <label class="flex items-center gap-3">

                                    <input type="checkbox">

                                    <span class="text-slate-600">
                                        Décoration
                                    </span>

                                </label>

                                <label class="flex items-center gap-3">

                                    <input type="checkbox">

                                    <span class="text-slate-600">
                                        Bijoux
                                    </span>

                                </label>

                                <label class="flex items-center gap-3">

                                    <input type="checkbox">

                                    <span class="text-slate-600">
                                        Poterie
                                    </span>

                                </label>

                            </div>

                        </div>

                        {{-- PRICE --}}
                        <div class="mb-10">

                            <h3 class="font-bold text-slate-900 mb-5">
                                Prix
                            </h3>

                            <input
                                type="range"
                                class="w-full accent-[#D86513]"
                            >

                            <div class="flex items-center justify-between mt-4 text-sm text-slate-500">

                                <span>
                                    5 000 FCFA
                                </span>

                                <span>
                                    100 000 FCFA
                                </span>

                            </div>

                        </div>

                        {{-- BUTTON --}}
                        <button
                            class="w-full h-14 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] transition text-white font-semibold"
                        >
                            Appliquer les filtres
                        </button>

                    </div>

                </aside>

                {{-- PRODUCTS --}}
                <div class="lg:col-span-3">

                    {{-- TOOLBAR --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">

                        <p class="text-slate-500">

                            24 produits trouvés

                        </p>

                        {{-- SORT --}}
                        <select
                            class="h-12 px-5 rounded-2xl border border-[#E7DDD1] bg-white outline-none"
                        >
                            <option>
                                Plus récents
                            </option>

                            <option>
                                Prix croissant
                            </option>

                            <option>
                                Prix décroissant
                            </option>

                            <option>
                                Popularité
                            </option>

                        </select>

                    </div>

                    {{-- GRID --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">

                        {{-- PRODUCT --}}
                        @include('composants.cartes.carte-produit', [
                            'title' => 'Sac artisanal premium',
                            'description' => 'Sac confectionné à la main avec des matériaux locaux.',
                            'price' => '18 000 FCFA',
                            'category' => 'Mode',
                            'badge' => 'Nouveau',
                            'image' => asset('images/produits/sac.jpg')
                        ])

                        {{-- PRODUCT --}}
                        @include('composants.cartes.carte-produit', [
                            'title' => 'Panier tressé africain',
                            'description' => 'Panier décoratif fait main.',
                            'price' => '12 000 FCFA',
                            'category' => 'Décoration',
                            'badge' => 'Best Seller',
                            'image' => asset('images/produits/panier.jpg')
                        ])

                        {{-- PRODUCT --}}
                        @include('composants.cartes.carte-produit', [
                            'title' => 'Bijou artisanal',
                            'description' => 'Bijou moderne inspiré de l’art africain.',
                            'price' => '9 500 FCFA',
                            'category' => 'Bijoux',
                            'badge' => 'Populaire',
                            'image' => asset('images/produits/bijou.jpg')
                        ])

                    </div>

                    {{-- PAGINATION --}}
                    <div class="mt-16 flex items-center justify-center gap-3">

                        <button class="w-12 h-12 rounded-2xl bg-white border border-[#EEE4D8]">
                            ←
                        </button>

                        <button class="w-12 h-12 rounded-2xl bg-[#D86513] text-white">
                            1
                        </button>

                        <button class="w-12 h-12 rounded-2xl bg-white border border-[#EEE4D8]">
                            2
                        </button>

                        <button class="w-12 h-12 rounded-2xl bg-white border border-[#EEE4D8]">
                            3
                        </button>

                        <button class="w-12 h-12 rounded-2xl bg-white border border-[#EEE4D8]">
                            →
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection