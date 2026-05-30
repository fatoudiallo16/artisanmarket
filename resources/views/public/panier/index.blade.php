@extends('layouts.app')

@section('title', 'Panier | ArtisanMarket')

@section('content')

    {{-- CART --}}
    <section class="py-16 bg-[#FAF7F2]">

        <div class="max-w-7xl mx-auto px-4">

            {{-- HEADER --}}
            <div class="mb-12">

                <div class="flex items-center gap-2 text-sm text-slate-500 mb-4">

                    <a href="{{ route('welcome') }}" class="hover:text-[#D86513]">
                        Accueil
                    </a>

                    <span>/</span>

                    <span class="text-slate-900 font-medium">
                        Panier
                    </span>

                </div>

                <h1 class="text-5xl font-black text-slate-900">

                    Mon Panier

                </h1>

            </div>

            {{-- CONTENT --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- PRODUCTS --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- ITEM --}}
                    <div class="bg-white rounded-[32px] border border-[#EEE4D8] p-6">

                        <div class="flex flex-col md:flex-row gap-6">

                            {{-- IMAGE --}}
                            <div class="w-full md:w-44 h-44 rounded-3xl overflow-hidden shrink-0">

                                <img
                                    src="{{ asset('images/produits/sac.jpg') }}"
                                    class="w-full h-full object-cover"
                                >

                            </div>

                            {{-- CONTENT --}}
                            <div class="flex-1">

                                <div class="flex items-start justify-between gap-6">

                                    <div>

                                        <span class="text-sm font-medium text-[#D86513]">

                                            Mode

                                        </span>

                                        <h2 class="mt-2 text-2xl font-bold text-slate-900">

                                            Sac artisanal premium

                                        </h2>

                                        <p class="mt-3 text-slate-500 leading-relaxed">

                                            Sac confectionné à la main avec des matériaux locaux.

                                        </p>

                                    </div>

                                    {{-- DELETE --}}
                                    <button
                                        class="text-slate-400 hover:text-red-500 transition"
                                    >
                                        ✕
                                    </button>

                                </div>

                                {{-- BOTTOM --}}
                                <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">

                                    {{-- QUANTITY --}}
                                    <div class="flex items-center border border-[#E7DDD1] rounded-2xl overflow-hidden w-fit">

                                        <button class="w-14 h-14 hover:bg-[#F8F4EF]">
                                            -
                                        </button>

                                        <div class="w-16 h-14 flex items-center justify-center font-bold">
                                            1
                                        </div>

                                        <button class="w-14 h-14 hover:bg-[#F8F4EF]">
                                            +
                                        </button>

                                    </div>

                                    {{-- PRICE --}}
                                    <div class="text-3xl font-black text-slate-900">

                                        18 000 FCFA

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- ITEM --}}
                    <div class="bg-white rounded-[32px] border border-[#EEE4D8] p-6">

                        <div class="flex flex-col md:flex-row gap-6">

                            {{-- IMAGE --}}
                            <div class="w-full md:w-44 h-44 rounded-3xl overflow-hidden shrink-0">

                                <img
                                    src="{{ asset('images/produits/panier.jpg') }}"
                                    class="w-full h-full object-cover"
                                >

                            </div>

                            {{-- CONTENT --}}
                            <div class="flex-1">

                                <div class="flex items-start justify-between gap-6">

                                    <div>

                                        <span class="text-sm font-medium text-[#D86513]">

                                            Décoration

                                        </span>

                                        <h2 class="mt-2 text-2xl font-bold text-slate-900">

                                            Panier tressé africain

                                        </h2>

                                        <p class="mt-3 text-slate-500 leading-relaxed">

                                            Panier décoratif fait main par des artisans locaux.

                                        </p>

                                    </div>

                                    <button
                                        class="text-slate-400 hover:text-red-500 transition"
                                    >
                                        ✕
                                    </button>

                                </div>

                                {{-- BOTTOM --}}
                                <div class="mt-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">

                                    {{-- QUANTITY --}}
                                    <div class="flex items-center border border-[#E7DDD1] rounded-2xl overflow-hidden w-fit">

                                        <button class="w-14 h-14 hover:bg-[#F8F4EF]">
                                            -
                                        </button>

                                        <div class="w-16 h-14 flex items-center justify-center font-bold">
                                            2
                                        </div>

                                        <button class="w-14 h-14 hover:bg-[#F8F4EF]">
                                            +
                                        </button>

                                    </div>

                                    {{-- PRICE --}}
                                    <div class="text-3xl font-black text-slate-900">

                                        24 000 FCFA

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- SUMMARY --}}
                <aside>

                    <div class="bg-white rounded-[32px] border border-[#EEE4D8] p-8 sticky top-28">

                        <h2 class="text-3xl font-black text-slate-900 mb-8">

                            Résumé

                        </h2>

                        {{-- SUBTOTAL --}}
                        <div class="space-y-5">

                            <div class="flex items-center justify-between text-slate-600">

                                <span>
                                    Sous-total
                                </span>

                                <span>
                                    42 000 FCFA
                                </span>

                            </div>

                            <div class="flex items-center justify-between text-slate-600">

                                <span>
                                    Livraison
                                </span>

                                <span>
                                    Gratuit
                                </span>

                            </div>

                        </div>

                        {{-- TOTAL --}}
                        <div class="border-t border-[#EEE4D8] mt-8 pt-8 flex items-center justify-between">

                            <span class="text-xl font-bold text-slate-900">
                                Total
                            </span>

                            <span class="text-3xl font-black text-[#D86513]">
                                42 000 FCFA
                            </span>

                        </div>

                        {{-- CHECKOUT --}}
                        <button
                            class="mt-10 w-full h-16 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] transition text-white font-bold text-lg shadow-lg shadow-orange-200"
                        >
                            Passer la commande
                        </button>

                        {{-- CONTINUE --}}
                        <a
                            href="{{ route('produits.index') }}"
                            class="mt-5 w-full h-16 rounded-2xl border border-[#E7DDD1] bg-white hover:border-[#D86513] hover:text-[#D86513] transition font-semibold flex items-center justify-center"
                        >
                            Continuer les achats
                        </a>

                    </div>

                </aside>

            </div>

        </div>

    </section>

@endsection