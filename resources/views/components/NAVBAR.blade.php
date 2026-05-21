<nav
    x-data="{ open: false }"
    class="bg-white shadow-md sticky top-0 z-50"
>

    <div class="max-w-7xl mx-auto px-4">

        <div class="flex items-center justify-between h-16">

            <!-- LOGO -->

            <a href="/" class="text-2xl font-bold text-orange-500">
                ArtisanMarket
            </a>

            <!-- MENU DESKTOP -->

            <div class="hidden md:flex items-center gap-8">

                <a href="#" class="hover:text-orange-500 transition">
                    Accueil
                </a>

                <a href="#" class="hover:text-orange-500 transition">
                    Produits
                </a>

                <a href="#" class="hover:text-orange-500 transition">
                    Catégories
                </a>

                <a href="#" class="hover:text-orange-500 transition">
                    Contatez-Nous
                </a>

            </div>

            <!-- ACTIONS -->

            <div class="hidden md:flex items-center gap-4">

                <button class="relative">

                    🛒

                    <span class="absolute -top-2 -right-2 bg-orange-500 text-white text-xs rounded-full px-2">
                        0
                    </span>

                </button>

                <a
                    href="#"
                    class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition"
                >
                    Se Connecter
                </a>

            </div>

            <!-- MOBILE BUTTON -->

            <button
                @click="open = !open"
                class="md:hidden text-2xl"
            >
                ☰
            </button>

        </div>

    </div>

    <!-- MOBILE MENU -->

    <div
        x-show="open"
        x-transition
        class="md:hidden bg-white border-t"
    >

        <div class="px-4 py-4 flex flex-col gap-4">

            <a href="#">Accueil</a>

            <a href="#">Produits</a>

            <a href="#">Catégories</a>

            <a href="#">Contatez-Nous</a>

            <a href="#">Se connecter</a>

        </div>

    </div>

</nav>