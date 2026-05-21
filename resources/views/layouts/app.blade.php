<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Artisan Market')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600,700|fraunces:600,700,800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/artisan-market.css') }}">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg am-navbar">
            <div class="container am-container">
                <a class="navbar-brand am-brand" href="{{ url('/') }}">
                    <span class="am-logo-mark">AM</span>
                    <span class="am-logo-text">ARTISAN <span>MARKET</span></span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="#navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mx-auto am-nav-links">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('produits.*') ? 'active' : '' }}" href="{{ route('produits.index') }}">Catalogue</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('annonces.*') ? 'active' : '' }}" href="{{ route('annonces.index') }}">Annonces</a>
                        </li>
                        @auth
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') || request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ Auth::user()->hasRole('admin') ? route('admin.dashboard') : route('home') }}">Tableau de bord</a>
                            </li>
                        @endauth
                    </ul>

                    <ul class="navbar-nav ms-auto align-items-lg-center am-nav-actions">
                        <li class="nav-item d-none d-lg-block">
                            <a class="am-icon-link" href="{{ route('produits.index') }}" aria-label="Rechercher">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m21 21-4.3-4.3m1.3-5.2a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0Z"/></svg>
                            </a>
                        </li>
                        @auth
                            @if(Auth::user()->hasRole('client'))
                                <li class="nav-item d-none d-lg-block position-relative">
                                    <a class="am-icon-link" href="{{ route('panier.index') }}" aria-label="Panier{{ ($cartCount ?? 0) > 0 ? ' — ' . $cartCount . ' article(s)' : '' }}">
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6h15l-1.7 8.5a2 2 0 0 1-2 1.5H9a2 2 0 0 1-2-1.5L5 3H2m7 18h.01M18 21h.01"/></svg>
                                        @if(($cartCount ?? 0) > 0)
                                            <span class="am-cart-badge">{{ $cartCount }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                        @endauth
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn am-btn-primary" href="{{ route('register') }}">S'inscrire</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @if(session('cart_added'))
                @php($added = session('cart_added'))
                <div class="container am-container pt-3">
                    <div class="am-cart-notice" role="status">
                        <div class="am-cart-notice-body">
                            <strong>Ajouté au panier</strong>
                            <p class="mb-0">
                                {{ $added['quantite'] }} × {{ $added['nom'] }}
                                — {{ number_format((float) ($added['cart_total'] ?? 0), 0, ',', ' ') }} FCFA
                                ({{ $added['cart_count'] }} article(s) dans le panier)
                            </p>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn am-btn-primary btn-sm" href="{{ route('panier.index') }}">Voir le panier</a>
                            <button type="button" class="btn btn-outline-secondary btn-sm" data-am-dismiss-notice>Continuer</button>
                        </div>
                    </div>
                </div>
            @elseif(session('success') || session('error'))
                <div class="container am-container pt-3">
                    <div class="alert {{ session('success') ? 'alert-success' : 'alert-danger' }} mb-0">
                        {{ session('success') ?? session('error') }}
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('[data-am-dismiss-notice]').forEach((btn) => {
            btn.addEventListener('click', () => btn.closest('.am-cart-notice')?.remove());
        });
        document.querySelectorAll('[data-am-image-upload]').forEach((wrap) => {
            const input = wrap.querySelector('[data-am-image-input]');
            const preview = wrap.querySelector('[data-am-image-preview]');
            const img = preview?.querySelector('img');
            if (!input || !preview || !img) return;
            input.addEventListener('change', () => {
                const file = input.files?.[0];
                if (!file) return;
                img.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
            });
        });
    </script>
</body>
</html>
