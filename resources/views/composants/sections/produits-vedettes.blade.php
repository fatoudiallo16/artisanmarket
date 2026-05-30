<section class="py-20 bg-white">

    <div class="max-w-7xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="flex items-end justify-between gap-6 mb-14">

            <div>

                <span class="text-[#D86513] font-semibold tracking-wide uppercase text-sm">

                    Boutique

                </span>

                <h2 class="mt-3 text-4xl font-black text-slate-900">

                    Produits vedettes

                </h2>

            </div>

            <a
                href="#"
                class="hidden md:flex items-center gap-2 text-[#D86513] font-semibold hover:gap-3 transition-all"
            >
                Voir tout →
            </a>

        </div>

        {{-- GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- PRODUCT --}}
            @include('composants.cartes.carte-produits', [
                'title' => 'Sac artisanal premium',
                'description' => 'Sac confectionné à la main avec des matériaux locaux.',
                'price' => '18 000 FCFA',
                'category' => 'Mode',
                'badge' => 'Nouveau',
                'image' => asset('images/produits/sac.jpg')
            ])

            {{-- PRODUCT --}}
            @include('composants.cartes.carte-produits', [
                'title' => 'Panier tressé africain',
                'description' => 'Panier décoratif fait main par des artisans locaux.',
                'price' => '12 000 FCFA',
                'category' => 'Décoration',
                'badge' => 'Best Seller',
                'image' => asset('images/produits/panier.jpg')
            ])

            {{-- PRODUCT --}}
            @include('composants.cartes.carte-produits', [
                'title' => 'Bijou artisanal',
                'description' => 'Bijou moderne inspiré de l’art africain traditionnel.',
                'price' => '9 500 FCFA',
                'category' => 'Bijoux',
                'badge' => 'Populaire',
                'image' => asset('images/produits/bijou.jpg')
            ])

            {{-- PRODUCT --}}
            @include('composants.cartes.carte-produits', [
                'title' => 'Poterie artisanale',
                'description' => 'Création en terre cuite réalisée à la main.',
                'price' => '15 000 FCFA',
                'category' => 'Poterie',
                'badge' => 'Authentique',
                'image' => asset('images/produits/poterie.jpg')
            ])

        </div>

    </div>

</section>
