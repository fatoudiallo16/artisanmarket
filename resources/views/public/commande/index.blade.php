@extends('layouts.app')

@section('title', 'Checkout | ArtisanMarket')

@section('content')

    {{-- CHECKOUT --}}
    <section class="py-16 bg-[#FAF7F2]">

        <div class="max-w-7xl mx-auto px-4">

            {{-- HEADER --}}
            <div class="mb-12">

                <div class="flex items-center gap-2 text-sm text-slate-500 mb-4">

                    <a href="{{ route('welcome') }}" class="hover:text-[#D86513]">
                        Accueil
                    </a>

                    <span>/</span>

                    <a href="{{ route('panier.index') }}" class="hover:text-[#D86513]">
                        Panier
                    </a>

                    <span>/</span>

                    <span class="text-slate-900 font-medium">
                        Checkout
                    </span>

                </div>

                <h1 class="text-5xl font-black text-slate-900">

                    Finaliser la commande

                </h1>

            </div>

            {{-- CONTENT --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                {{-- FORM --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- CLIENT INFO --}}
                    <div class="bg-white rounded-[32px] border border-[#EEE4D8] p-8">

                        <h2 class="text-3xl font-black text-slate-900 mb-8">

                            Informations client

                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- NOM --}}
                            <div>

                                <label class="block text-sm font-semibold text-slate-700 mb-3">
                                    Nom complet
                                </label>

                                <input
                                    type="text"
                                    class="w-full h-14 rounded-2xl border border-[#E7DDD1] bg-[#FAF7F2] px-5 outline-none focus:ring-2 focus:ring-[#D86513]"
                                    placeholder="Votre nom"
                                >

                            </div>

                            {{-- TELEPHONE --}}
                            <div>

                                <label class="block text-sm font-semibold text-slate-700 mb-3">
                                    Téléphone
                                </label>

                                <input
                                    type="text"
                                    class="w-full h-14 rounded-2xl border border-[#E7DDD1] bg-[#FAF7F2] px-5 outline-none focus:ring-2 focus:ring-[#D86513]"
                                    placeholder="+223 XX XX XX XX"
                                >

                            </div>

                            {{-- EMAIL --}}
                            <div class="md:col-span-2">

                                <label class="block text-sm font-semibold text-slate-700 mb-3">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    class="w-full h-14 rounded-2xl border border-[#E7DDD1] bg-[#FAF7F2] px-5 outline-none focus:ring-2 focus:ring-[#D86513]"
                                    placeholder="email@example.com"
                                >

                            </div>

                        </div>

                    </div>

                    {{-- LIVRAISON --}}
                    <div class="bg-white rounded-[32px] border border-[#EEE4D8] p-8">

                        <h2 class="text-3xl font-black text-slate-900 mb-8">

                            Adresse de livraison

                        </h2>

                        <div class="space-y-6">

                            {{-- ADRESSE --}}
                            <div>

                                <label class="block text-sm font-semibold text-slate-700 mb-3">
                                    Adresse
                                </label>

                                <input
                                    type="text"
                                    class="w-full h-14 rounded-2xl border border-[#E7DDD1] bg-[#FAF7F2] px-5 outline-none focus:ring-2 focus:ring-[#D86513]"
                                    placeholder="Votre adresse"
                                >

                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                {{-- VILLE --}}
                                <div>

                                    <label class="block text-sm font-semibold text-slate-700 mb-3">
                                        Ville
                                    </label>

                                    <input
                                        type="text"
                                        class="w-full h-14 rounded-2xl border border-[#E7DDD1] bg-[#FAF7F2] px-5 outline-none focus:ring-2 focus:ring-[#D86513]"
                                        placeholder="Bamako"
                                    >

                                </div>

                                {{-- PAYS --}}
                                <div>

                                    <label class="block text-sm font-semibold text-slate-700 mb-3">
                                        Pays
                                    </label>

                                    <input
                                        type="text"
                                        class="w-full h-14 rounded-2xl border border-[#E7DDD1] bg-[#FAF7F2] px-5 outline-none focus:ring-2 focus:ring-[#D86513]"
                                        placeholder="Mali"
                                    >

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- PAYMENT --}}
                    <div class="bg-white rounded-[32px] border border-[#EEE4D8] p-8">

                        <h2 class="text-3xl font-black text-slate-900 mb-8">

                            Méthode de paiement

                        </h2>

                        <div class="space-y-5">

                            {{-- WAVE --}}
                            <label class="flex items-center gap-5 p-5 rounded-2xl border border-[#EEE4D8] hover:border-[#D86513] transition cursor-pointer">

                                <input type="radio" name="payment">

                                <div>

                                    <h3 class="font-bold text-slate-900">
                                        Wave
                                    </h3>

                                    <p class="text-sm text-slate-500">
                                        Paiement mobile sécurisé
                                    </p>

                                </div>

                            </label>

                            {{-- ORANGE MONEY --}}
                            <label class="flex items-center gap-5 p-5 rounded-2xl border border-[#EEE4D8] hover:border-[#D86513] transition cursor-pointer">

                                <input type="radio" name="payment">

                                <div>

                                    <h3 class="font-bold text-slate-900">
                                        Orange Money
                                    </h3>

                                    <p class="text-sm text-slate-500">
                                        Paiement rapide et sécurisé
                                    </p>

                                </div>

                            </label>

                            {{-- CARD --}}
                            <label class="flex items-center gap-5 p-5 rounded-2xl border border-[#EEE4D8] hover:border-[#D86513] transition cursor-pointer">

                                <input type="radio" name="payment">

                                <div>

                                    <h3 class="font-bold text-slate-900">
                                        Carte bancaire
                                    </h3>

                                    <p class="text-sm text-slate-500">
                                        Visa / Mastercard
                                    </p>

                                </div>

                            </label>

                        </div>

                    </div>

                </div>

                {{-- SUMMARY --}}
                <aside>

                    <div class="bg-white rounded-[32px] border border-[#EEE4D8] p-8 sticky top-28">

                        <h2 class="text-3xl font-black text-slate-900 mb-8">

                            Résumé commande

                        </h2>

                        {{-- PRODUCT --}}
                        <div class="flex items-center gap-4 pb-6 border-b border-[#EEE4D8]">

                            <div class="w-24 h-24 rounded-2xl overflow-hidden">

                                <img
                                    src="{{ asset('images/produits/sac.jpg') }}"
                                    class="w-full h-full object-cover"
                                >

                            </div>

                            <div class="flex-1">

                                <h3 class="font-bold text-slate-900">

                                    Sac artisanal premium

                                </h3>

                                <p class="mt-2 text-sm text-slate-500">
                                    Quantité : 1
                                </p>

                            </div>

                            <div class="font-bold text-slate-900">
                                18 000
                            </div>

                        </div>

                        {{-- TOTALS --}}
                        <div class="space-y-5 mt-8">

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

                        {{-- BTN --}}
                        <button
                            class="mt-10 w-full h-16 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] transition text-white font-bold text-lg shadow-lg shadow-orange-200"
                        >
                            Confirmer la commande
                        </button>

                    </div>

                </aside>

            </div>

        </div>

    </section>

@endsection