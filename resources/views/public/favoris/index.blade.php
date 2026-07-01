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
                        {{ $favoris->count() }}
                    </span>

                </div>

            </div>

            {{-- GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-8">

                @forelse($favoris as $produit)
                    @php
                        $categoryName = $produit->categorie?->name ?? 'Artisanat';
                    @endphp
                    <div class="relative group/fav">

                        {{-- REMOVE --}}
                        <form method="POST" action="{{ route('favoris.toggle', $produit) }}" class="absolute top-5 right-5 z-20">
                            @csrf
                            <button
                                type="submit"
                                class="w-12 h-12 rounded-2xl bg-white shadow-lg hover:bg-red-500 hover:text-white transition flex items-center justify-center font-bold text-slate-700"
                                title="Retirer des favoris"
                            >
                                ✕
                            </button>
                        </form>

                        @include('composants.cartes.carte-produits', [
                            'title' => $produit->nom,
                            'description' => \Illuminate\Support\Str::limit($produit->description, 90),
                            'price' => number_format((float) $produit->prix, 0, ' ', ' ') . ' FCFA',
                            'category' => ucfirst($categoryName),
                            'badge' => $produit->stock > 0 ? 'Disponible' : 'Rupture',
                            'image' => $produit->image_url,
                            'url' => route('produits.show', $produit),
                        ])

                    </div>
                @empty
                    <div class="col-span-full bg-white rounded-[40px] border border-[#EEE4D8] py-24 px-10 text-center">

                        <div class="text-7xl mb-8 text-[#D86513]/30">
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
                @endforelse

            </div>

        </div>

    </section>

@endsection
