@extends('layouts.app')

@section('title', 'Détail Produit | ArtisanMarket')

@section('content')

    {{-- PRODUCT DETAIL --}}
    <section class="py-16 bg-[#FAF7F2]">

        <div class="max-w-7xl mx-auto px-4">

            {{-- BREADCRUMB --}}
            <div class="flex items-center gap-2 text-sm text-slate-500 mb-10">

                <a href="{{ route('welcome') }}" class="hover:text-[#D86513]">
                    Accueil
                </a>

                <span>/</span>

                <a href="{{ route('produits.index') }}" class="hover:text-[#D86513]">
                    Produits
                </a>

                <span>/</span>

                <span class="text-slate-900 font-medium">
                    Sac artisanal premium
                </span>

            </div>

            {{-- MAIN --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-start">

                {{-- LEFT --}}
                <div>

                    {{-- MAIN IMAGE --}}
                    <div class="bg-white rounded-[40px] overflow-hidden border border-[#EEE4D8] shadow-sm">

                        <img
                            src="{{ asset('images/produits/sac.jpg') }}"
                            alt=""
                            class="w-full h-[600px] object-cover"
                        >

                    </div>

                    {{-- THUMBNAILS --}}
                    <div class="grid grid-cols-4 gap-4 mt-6">

                        <div class="rounded-2xl overflow-hidden border-2 border-[#D86513]">

                            <img
                                src="{{ asset('images/produits/sac.jpg') }}"
                                class="w-full h-28 object-cover"
                            >

                        </div>

                        <div class="rounded-2xl overflow-hidden border border-[#EEE4D8]">

                            <img
                                src="{{ asset('images/produits/panier.jpg') }}"
                                class="w-full h-28 object-cover"
                            >

                        </div>

                        <div class="rounded-2xl overflow-hidden border border-[#EEE4D8]">

                            <img
                                src="{{ asset('images/produits/bijou.jpg') }}"
                                class="w-full h-28 object-cover"
                            >

                        </div>

                        <div class="rounded-2xl overflow-hidden border border-[#EEE4D8]">

                            <img
                                src="{{ asset('images/produits/poterie.jpg') }}"
                                class="w-full h-28 object-cover"
                            >

                        </div>

                    </div>

                </div>

                {{-- RIGHT --}}
                <div>

                    {{-- CATEGORY --}}
                    <span class="inline-flex px-4 py-2 rounded-full bg-[#FFF1E7] text-[#D86513] font-semibold text-sm">

                        Mode

                    </span>

                    {{-- TITLE --}}
                    <h1 class="mt-6 text-5xl font-black text-slate-900 leading-tight">

                        Sac artisanal premium

                    </h1>

                    {{-- RATING --}}
                    <div class="flex items-center gap-4 mt-6">

                        <div class="flex items-center gap-1 text-yellow-500">

                            ★★★★★

                        </div>

                        <span class="text-slate-500">
                            (24 avis)
                        </span>

                    </div>

                    {{-- PRICE --}}
                    <div class="mt-8">

                        <span class="text-5xl font-black text-slate-900">

                            18 000 FCFA

                        </span>

                    </div>

                    {{-- DESCRIPTION --}}
                    <p class="mt-8 text-lg leading-relaxed text-slate-600">

                        Sac artisanal confectionné à la main avec des matériaux locaux de haute qualité.
                        Chaque pièce est unique et reflète le savoir-faire traditionnel africain.

                    </p>

                    {{-- STOCK --}}
                    <div class="mt-8 flex items-center gap-3">

                        <span class="w-3 h-3 rounded-full bg-green-500"></span>

                        <span class="font-medium text-slate-700">

                            En stock

                        </span>

                    </div>

                    {{-- QUANTITY --}}
                    <div class="mt-10">

                        <h3 class="font-bold text-slate-900 mb-4">

                            Quantité

                        </h3>

                        <div class="flex items-center gap-4">

                            <div class="flex items-center border border-[#E7DDD1] rounded-2xl overflow-hidden">

                                <button class="w-14 h-14 bg-white hover:bg-[#F7F2EC]">
                                    -
                                </button>

                                <div class="w-16 h-14 flex items-center justify-center font-bold">
                                    1
                                </div>

                                <button class="w-14 h-14 bg-white hover:bg-[#F7F2EC]">
                                    +
                                </button>

                            </div>

                        </div>

                    </div>

                    {{-- BUTTONS --}}
                    <div class="mt-10 flex flex-col sm:flex-row gap-5">

                        {{-- ADD CART --}}
                        <button
                            class="flex-1 h-16 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] transition text-white font-bold text-lg shadow-lg shadow-orange-200"
                        >
                            Ajouter au panier
                        </button>

                        {{-- FAVORIS --}}
                        <button
                            class="w-16 h-16 rounded-2xl border border-[#E7DDD1] bg-white hover:border-[#D86513] hover:text-[#D86513] transition flex items-center justify-center"
                        >
                            ♡
                        </button>

                    </div>

                    {{-- SELLER --}}
                    <div class="mt-14 bg-white rounded-[32px] border border-[#EEE4D8] p-8">

                        <div class="flex items-center gap-5">

                            <div class="w-20 h-20 rounded-3xl overflow-hidden">

                                <img
                                    src="{{ asset('images/hero/artisan.jpg') }}"
                                    alt=""
                                    class="w-full h-full object-cover"
                                >

                            </div>

                            <div>

                                <h3 class="text-2xl font-bold text-slate-900">

                                    Fatou Création

                                </h3>

                                <p class="mt-2 text-slate-500">

                                    Artisan vérifié • 124 produits

                                </p>

                            </div>

                        </div>

                        <button
                            class="mt-8 w-full h-14 rounded-2xl border border-[#D86513] text-[#D86513] hover:bg-[#D86513] hover:text-white transition font-semibold"
                        >
                            Voir la boutique
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection