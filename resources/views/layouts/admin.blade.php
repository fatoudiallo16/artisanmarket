<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body
    x-data="{ open:true }"
    class="bg-slate-100">

<div class="flex min-h-screen">

    <!-- Sidebar -->

    <aside
        :class="open ? 'w-72' : 'w-20'"
        class="bg-slate-900 text-white transition-all duration-300">

        <!-- Logo -->

        <div
            class="h-20 flex items-center justify-center border-b border-slate-800">

            <h1
                x-show="open"
                class="text-2xl font-bold text-amber-400">

                ArtisanMarket

            </h1>

        </div>

        <!-- Menu -->

        <nav class="p-4 space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-amber-400 font-semibold shadow-inner' : 'hover:bg-slate-800 text-slate-300' }}">

                📊

                <span x-show="open">
                    Dashboard
                </span>

            </a>

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.users.*') ? 'bg-slate-800 text-amber-400 font-semibold shadow-inner' : 'hover:bg-slate-800 text-slate-300' }}">

                👥

                <span x-show="open">
                    Utilisateurs
                </span>

            </a>

            <a href="{{ route('admin.vendeurs.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.vendeurs.*') ? 'bg-slate-800 text-amber-400 font-semibold shadow-inner' : 'hover:bg-slate-800 text-slate-300' }}">

                🏪

                <span x-show="open">
                    Vendeurs
                </span>

            </a>

            <a href="{{ route('produits.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('produits.*') ? 'bg-slate-800 text-amber-400 font-semibold shadow-inner' : 'hover:bg-slate-800 text-slate-300' }}">

                📦

                <span x-show="open">
                    Produits
                </span>

            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.categories.*') ? 'bg-slate-800 text-amber-400 font-semibold shadow-inner' : 'hover:bg-slate-800 text-slate-300' }}">

                🏷️

                <span x-show="open">
                    Catégories
                </span>

            </a>

            <a href="{{ route('admin.commandes.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.commandes.*') ? 'bg-slate-800 text-amber-400 font-semibold shadow-inner' : 'hover:bg-slate-800 text-slate-300' }}">

                🛒

                <span x-show="open">
                    Commandes
                </span>

            </a>

            <a href="#"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all hover:bg-slate-800 text-slate-300">

                📈

                <span x-show="open">
                    Statistiques
                </span>

            </a>

        </nav>

    </aside>

    <!-- Contenu -->

    <div class="flex-1">

        <!-- Header -->

        <header
            class="bg-white shadow-sm h-20 px-6 flex items-center justify-between">

            <button
                @click="open = !open"
                class="text-2xl">

                ☰

            </button>

            <div class="flex items-center gap-4">

                <span>

                    {{ auth()->user()->nom ?? auth()->user()->name }}

                </span>

            </div>

        </header>

        <!-- Page -->

        <main class="p-8">

            @yield('content')

        </main>

    </div>

</div>

</body>

</html>