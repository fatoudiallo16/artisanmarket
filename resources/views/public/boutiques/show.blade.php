@extends('layouts.app')

@section('title', 'Boutique Artisan | ArtisanMarket')

@section('content')

    {{-- SHOP --}}
    <section class="bg-[#FAF7F2] min-h-screen pb-20">

        {{-- BANNER --}}
        <div class="relative h-[380px] overflow-hidden">

            <img
                src="{{ asset('images/hero/hero-1.jpg') }}"
                alt=""
                class="w-full h-full object-cover"
            >

            <div class="absolute inset-0 bg-black/40"></div>

        </div>

        <div class="max-w-7xl mx-auto px-4">

            {{-- SHOP HEADER --}}
            <div class="relative -mt-24 z-20">

                <div class="bg-white rounded-[40px] border border-[#EEE4D8] shadow-xl p-10">

                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-10">

                        {{-- LEFT --}}
                        <div class="flex flex-col md:flex-row md:items-center gap-8">

                            {{-- AVATAR --}}
                            <div class="w-40 h-40 rounded-[40px] overflow-hidden border-4 border-white shadow-xl shrink-0">

                                <img
                                    src="{{ asset('images/hero/artisan.jpg') }}"
                                    alt=""
                                    class="w-full h-full object-cover"
                                >

                            </div>

                            {{-- INFO --}}
                            <div>

                                <span class="inline-flex px-4 py-2 rounded-full bg-[#FFF1E7] text-[#D86513] font-semibold text-sm">

                                    Artisan vérifié

                                </span>

                                <h1 class="mt-5 text-5xl font-black text-slate-900">

                                    Fatou Création

                                </h1>

                                <p class="mt-5 text-lg leading-relaxed text-slate-500 max-w-2xl">

                                    Boutique spécialisée dans les créations artisanales africaines modernes :
                                    sacs, bijoux, décoration et objets faits main.

                                </p>

                                {{-- STATS --}}
                                <div class="flex flex-wrap items-center gap-8 mt-8">

                                    <div>

                                        <span class="block text-3xl font-black text-slate-900">
                                            124
                                        </span>

                                        <span class="text-slate-500">
                                            Produits
                                        </span>

                                    </div>

                                    <div>

                                        <span class="block text-3xl font-black text-slate-900">
                                            4.9
                                        </span>

                                        <span class="text-slate-500">
                                            Évaluation
                                        </span>

                                    </div>

                                    <div>

                                        <span class="block text-3xl font-black text-slate-900">
                                            2 340
                                        </span>

                                        <span class="text-slate-500">
                                            Ventes
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- ACTIONS --}}
                        <div class="flex flex-col sm:flex-row gap-5">

                            <button
                                class="h-16 px-10 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] transition text-white font-bold"
                            >
                                Contacter
                            </button>

                            <button
                                class="h-16 px-10 rounded-2xl border border-[#E7DDD1] bg-white hover:border-[#D86513] hover:text-[#D86513] transition font-semibold"
                            >
                                Suivre la boutique
                            </button>

                        </div>

                    </div>

                </div>

            </div>

            {{-- PRODUCTS --}}
            <div class="mt-20">

                {{-- HEADER --}}
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">

                    <div>

                        <h2 class="text-4xl font-black text-slate-900">

                            Produits de la boutique

                        </h2>

                        <p class="mt-4 text-slate-500">

                            Découvrez les créations disponibles.

                        </p>

                    </div>

                    {{-- FILTER --}}
                    <select
                        class="h-14 px-6 rounded-2xl border border-[#E7DDD1] bg-white outline-none"
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

                    </select>

                </div>

                {{-- GRID --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8">

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

                    {{-- PRODUCT --}}
                    @include('composants.cartes.carte-produit', [
                        'title' => 'Poterie artisanale',
                        'description' => 'Objet décoratif traditionnel moderne.',
                        'price' => '14 000 FCFA',
                        'category' => 'Poterie',
                        'badge' => 'Tendance',
                        'image' => asset('images/produits/poterie.jpg')
                    ])

                </div>

            </div>

        </div>

    </section>

@endsection