<section class="relative overflow-hidden bg-[#FAF7F2]">

    {{-- BACKGROUND SHAPES --}}
    <div class="absolute inset-0 pointer-events-none overflow-hidden">

        <div class="absolute top-0 left-0 w-72 h-72 bg-[#EBC9A8]/30 rounded-full blur-3xl"></div>

        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-[#D86513]/10 rounded-full blur-3xl"></div>

    </div>

    <div class="relative max-w-7xl mx-auto px-4 py-14 lg:py-20">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- LEFT --}}
            <div>

                {{-- BADGE --}}
                <div class="inline-flex items-center gap-2 bg-white border border-[#E8DED2] rounded-full px-5 py-2 shadow-sm mb-8">

                    <span class="w-2 h-2 rounded-full bg-[#D86513]"></span>

                    <span class="text-sm font-medium text-slate-700">
                        Marketplace artisanale africaine
                    </span>

                </div>

                {{-- TITLE --}}
                <h1 class="text-5xl lg:text-6xl font-black leading-tight text-slate-900">

                    Découvrez des créations

                    <span class="text-[#D86513]">
                        uniques
                    </span>

                    et authentiques.

                </h1>

                {{-- DESCRIPTION --}}
                <p class="mt-7 text-lg leading-relaxed text-slate-600 max-w-xl">

                    ArtisanMarket connecte artisans, créateurs et passionnés
                    autour d’une marketplace moderne dédiée au savoir-faire local.

                </p>

                {{-- BUTTONS --}}
                <div class="mt-10 flex flex-col sm:flex-row gap-5">

                    <a
                        href="{{ route('produits.index') }}"
                        class="h-14 px-8 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] transition text-white font-semibold flex items-center justify-center shadow-lg shadow-orange-200"
                    >
                        Explorer les produits
                    </a>

                    <a
                        href="#"
                        class="h-14 px-8 rounded-2xl border border-[#DDD2C5] bg-white hover:border-[#D86513] hover:text-[#D86513] transition font-semibold flex items-center justify-center"
                    >
                        Devenir vendeur
                    </a>

                </div>

                {{-- STATS --}}
                <div class="mt-14 grid grid-cols-3 gap-6">

                    <div>

                        <h3 class="text-3xl font-black text-slate-900">
                            500+
                        </h3>

                        <p class="mt-2 text-sm text-slate-500">
                            Produits artisanaux
                        </p>

                    </div>

                    <div>

                        <h3 class="text-3xl font-black text-slate-900">
                            120+
                        </h3>

                        <p class="mt-2 text-sm text-slate-500">
                            Créateurs locaux
                        </p>

                    </div>

                    <div>

                        <h3 class="text-3xl font-black text-slate-900">
                            4.9★
                        </h3>

                        <p class="mt-2 text-sm text-slate-500">
                            Satisfaction client
                        </p>

                    </div>

                </div>

            </div>

            {{-- RIGHT --}}
            <div class="relative">

                {{-- MAIN IMAGE --}}
                <div class="relative z-10 overflow-hidden rounded-[40px] shadow-2xl shadow-[#E6D7C7]">

                    <img
                        src="{{ asset('images/hero/hero-1.jpg') }}"
                        alt="Artisanat africain"
                        class="w-full h-[500px] lg:h-[580px] object-cover"
                    >

                </div>

                {{-- FLOATING CARD --}}
                <div class="absolute -bottom-8 -left-6 bg-white rounded-3xl p-5 shadow-2xl w-64 z-20">

                    <div class="flex items-center gap-4">

                        <div class="w-14 h-14 rounded-2xl overflow-hidden">

                            <img
                                src="{{ asset('images/hero/artisan.jpg') }}"
                                alt=""
                                class="w-full h-full object-cover"
                            >

                        </div>

                        <div>

                            <h4 class="font-bold text-slate-900">
                                Artisan vérifié
                            </h4>

                            <p class="text-sm text-slate-500">
                                Produits authentiques
                            </p>

                        </div>

                    </div>

                    <p class="mt-4 text-sm leading-relaxed text-slate-600">

                        “Chaque création raconte une histoire unique issue du savoir-faire africain.”

                    </p>

                </div>

                {{-- DOTS --}}
                <div class="flex items-center justify-center gap-3 mt-8">

                    <span class="w-3 h-3 rounded-full bg-[#D86513]"></span>

                    <span class="w-3 h-3 rounded-full bg-[#D8CFC3]"></span>

                    <span class="w-3 h-3 rounded-full bg-[#D8CFC3]"></span>

                </div>

            </div>

        </div>

    </div>

</section>