<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'ArtisanMarket — Marketplace artisanale du Mali')
    </title>

    <meta name="description" content="@yield('meta_description', 'Découvrez des créations artisanales uniques du Mali : bijoux, tissus bogolan, poterie, sculptures bois et plus. Soutenez nos artisans talentueux.')">
    <meta name="keywords" content="artisanat, Mali, bogolan, bijoux, poterie, sculpture, tissus, marketplace, fait main">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'ArtisanMarket — Marketplace artisanale du Mali')">
    <meta property="og:description" content="@yield('meta_description', 'Découvrez des créations artisanales uniques du Mali. Soutenez nos artisans talentueux.')">
    <meta property="og:site_name" content="ArtisanMarket">
    <meta property="og:locale" content="fr_FR">

    <link rel="canonical" href="{{ url()->current() }}">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="bg-[#FAF7F2] text-slate-800 antialiased">

    {{-- APP --}}
    <div class="min-h-screen flex flex-col">

        {{-- TOPBAR --}}
        @include('composants.navigation.topbar')

        {{-- NAVBAR --}}
        @include('composants.navigation.NAVBAR')

        {{-- CONTENT --}}
        <main class="flex-1">

            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 pt-4">
                    <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-7xl mx-auto px-4 pt-4">
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="max-w-7xl mx-auto px-4 pt-4">
                    <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                        <ul class="mb-0 list-disc ps-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')

        </main>

        {{-- FOOTER --}}
        @include('composants.pied-page.footer')

    </div>

</body>

</html>
