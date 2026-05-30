<nav
    x-data="{ open: false }"
    class="bg-white border-b border-[#EFE7DD] sticky top-0 z-50"
>

    <div class="max-w-7xl mx-auto px-4">

        <div class="h-20 flex items-center justify-between gap-8">

            {{-- LOGO --}}
            <a
                href="{{ route('welcome') }}"
                class="flex items-center gap-3 shrink-0"
            >

                {{-- ICON --}}
                <div class="w-12 h-12 rounded-2xl border-2 border-[#D86513] flex items-center justify-center">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 text-[#D86513]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 8h14l-1 11H6L5 8z"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 8V6a3 3 0 016 0v2"
                        />
                    </svg>

                </div>

                {{-- TEXT --}}
                <div>

                    <h1 class="text-4xl font-black leading-none">

                        <span class="text-slate-900">
                            Artisan
                        </span>

                        <span class="text-[#D86513]">
                            Market
                        </span>

                    </h1>

                </div>

            </a>

            {{-- MENU DESKTOP --}}
            <div class="hidden lg:flex items-center gap-8">

                <a
                    href="{{ route('welcome') }}"
                    class="text-[#D86513] font-semibold border-b-2 border-[#D86513] pb-1"
                >
                    Accueil
                </a>

                <a
                    href="{{ route('produits.index') }}"
                    class="text-slate-700 hover:text-[#D86513] transition font-medium"
                >
                    Produits
                </a>

                <a
                    href="{{ route('produits.index') }}"
                    class="text-slate-700 hover:text-[#D86513] transition font-medium"
                >
                    Catégories
                </a>

                <a
                    href="{{ route('produits.index') }}"
                    class="text-slate-700 hover:text-[#D86513] transition font-medium"
                >
                    Boutiques
                </a>

                <a
                    href="{{ route('annonces.index') }}"
                    class="text-slate-700 hover:text-[#D86513] transition font-medium"
                >
                    Annonces
                </a>

            </div>

            {{-- RIGHT --}}
            <div class="hidden lg:flex items-center gap-5 flex-1 justify-end">

                {{-- SEARCH --}}
                <div class="relative max-w-md w-full">

                    <input
                        type="text"
                        placeholder="Rechercher un produit, un artisan..."
                        class="w-full h-12 rounded-2xl border border-[#E7DDD1] bg-[#FAF7F2] pl-5 pr-14 text-sm outline-none focus:ring-2 focus:ring-[#D86513] focus:border-[#D86513]"
                    >

                    <button
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-[#D86513]"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <circle cx="11" cy="11" r="7" />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 21l-4.35-4.35"
                            />
                        </svg>

                    </button>

                </div>

                {{-- FAVORIS --}}
                <a
                    href="{{ route('favoris.index') }}"
                    class="relative text-slate-700 hover:text-[#D86513] transition"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                        />
                    </svg>

                    <span class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-[#D86513] text-white text-[10px] flex items-center justify-center">
                        3
                    </span>

                </a>

                {{-- PANIER --}}
                <a
                    href="{{ route('panier.index') }}"
                    class="relative text-slate-700 hover:text-[#D86513] transition"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4"
                        />

                        <circle cx="9" cy="19" r="1" />

                        <circle cx="17" cy="19" r="1" />
                    </svg>

                    <span class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-[#D86513] text-white text-[10px] flex items-center justify-center">
                        {{ $cartCount ?? 0 }}
                    </span>

                </a>

                {{-- AUTH --}}
                @guest

                    <a
                        href="{{ route('login') }}"
                        class="font-medium text-slate-700 hover:text-[#D86513]"
                    >
                        Connexion
                    </a>

                    <a
                        href="{{ route('register') }}"
                        class="h-12 px-6 rounded-2xl bg-[#D86513] hover:bg-[#C45B10] transition text-white font-semibold flex items-center"
                    >
                        S'inscrire
                    </a>

                @else

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11 rounded-full bg-[#D86513] text-white flex items-center justify-center font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                    </div>

                @endguest

            </div>

            {{-- MOBILE BUTTON --}}
            <button
                @click="open = !open"
                class="lg:hidden p-2 rounded-xl hover:bg-[#F3EEE7]"
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-7 h-7"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>

            </button>

        </div>

    </div>

    {{-- MOBILE MENU --}}
    <div
        x-show="open"
        x-transition
        class="lg:hidden border-t border-[#EFE7DD] bg-white"
    >

        <div class="px-4 py-6 space-y-5">

            <input
                type="text"
                placeholder="Rechercher..."
                class="w-full h-12 rounded-2xl border border-[#E7DDD1] bg-[#FAF7F2] px-4 outline-none"
            >

            <a href="{{ route('welcome') }}" class="block font-medium text-[#D86513]">
                Accueil
            </a>

            <a href="{{ route('produits.index') }}" class="block font-medium text-slate-700">
                Produits
            </a>

            <a href="{{ route('produits.index') }}" class="block font-medium text-slate-700">
                Catégories
            </a>

            <a href="{{ route('produits.index') }}" class="block font-medium text-slate-700">
                Boutiques
            </a>

            <a href="{{ route('annonces.index') }}" class="block font-medium text-slate-700">
                Annonces
            </a>

            <a href="{{ route('favoris.index') }}" class="block font-medium text-slate-700">
                Favoris
            </a>

            <a href="{{ route('panier.index') }}" class="block font-medium text-slate-700">
                Panier
            </a>

        </div>

    </div>

</nav>
