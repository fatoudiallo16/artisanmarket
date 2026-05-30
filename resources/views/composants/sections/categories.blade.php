<section class="py-16 bg-[#FAF7F2]">

    <div class="max-w-7xl mx-auto px-4">

        {{-- HEADER --}}
        <div class="flex items-end justify-between gap-6 mb-14">

            <div>

                <span class="text-[#D86513] font-semibold tracking-wide uppercase text-sm">

                    Explorer

                </span>

                <h2 class="mt-3 text-4xl font-black text-slate-900">

                    Catégories populaires

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

            {{-- MODE --}}
            @include('composants.cartes.carte-categories', [
                'title' => 'Mode',
                'description' => 'Vêtements, sacs et créations textiles artisanales.',
                'image' => asset('images/categories/mode.jpg')
            ])

            {{-- DECORATION --}}
            @include('composants.cartes.carte-categories', [
                'title' => 'Décoration',
                'description' => 'Objets artisanaux et décorations authentiques.',
                'image' => asset('images/categories/deco.jpg')
            ])

            {{-- BIJOUX --}}
            @include('composants.cartes.carte-categories', [
                'title' => 'Bijoux',
                'description' => 'Bijoux africains modernes et faits main.',
                'image' => asset('images/categories/bijoux.jpg')
            ])

            {{-- POTERIE --}}
            @include('composants.cartes.carte-categories', [
                'title' => 'Poterie',
                'description' => 'Poteries et créations en terre cuite artisanales.',
                'image' => asset('images/categories/poterie.jpg')
            ])

        </div>

    </div>

</section>
