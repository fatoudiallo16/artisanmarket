@extends('layouts.app')

@section('content')

<!-- HERO SECTION -->

<section class="bg-orange-50 py-20">

    <div class="max-w-7xl mx-auto px-4">

        <div class="grid md:grid-cols-2 gap-10 items-center">

            <!-- TEXTE -->

            <div>

                <h1 class="text-5xl md:text-6xl font-bold leading-tight">

                    Découvrez l’artisanat authentique malienne

                </h1>

                <p class="mt-6 text-lg text-gray-600">

                    Une plateforme moderne dédiée aux créations artisanales uniques.

                </p>

                <div class="mt-8 flex gap-4">

                    <button class="bg-orange-500 text-white px-6 py-3 rounded-xl hover:bg-orange-600 transition">

                        Explorer les produits

                    </button>

                    <button class="border border-orange-500 text-orange-500 px-6 py-3 rounded-xl hover:bg-orange-100 transition">

                        Devenir vendeur

                    </button>

                </div>

            </div>

            <!-- IMAGE -->

            <div>

                <img
                    src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f"
                    class="rounded-3xl shadow-2xl"
                >

            </div>

        </div>

    </div>

    
<section class="py-20">

    <div class="max-w-7xl mx-auto px-4">

        <!-- TITRE -->

        <div class="flex items-center justify-between mb-10">

            <div>

                <h2 class="text-4xl font-bold">
                    Produits populaires
                </h2>

                <p class="text-gray-500 mt-2">
                    Découvrez les créations les plus appréciées.
                </p>

            </div>

        </div>

        <!-- GRID -->

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">

            <!-- CARD 1 -->

            <x-product-card
                image="https://images.unsplash.com/photo-1523275335684-37898b6baf30"
                title="Sac artisanal"
                description="Fabriqué à la main par des artisans maliens."
                price="15 000 FCFA"
            />

            <!-- CARD 2 -->

            <x-product-card
                image="https://images.unsplash.com/photo-1505740420928-5e560c06d30e"
                title="Bijou traditionnel"
                description="Bijou authentique inspiré des traditions africaines."
                price="8 500 FCFA"
            />

            <!-- CARD 3 -->

            <x-product-card
                image="https://images.unsplash.com/photo-1512436991641-6745cdb1723f"
                title="Tissu Bogolan"
                description="Tissu africain premium de haute qualité."
                price="25 000 FCFA"
            />

        </div>

    </div>

</section>

</section>

@endsection

<!-- PRODUITS -->
