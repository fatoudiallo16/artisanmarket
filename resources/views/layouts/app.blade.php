<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'ArtisanMarket')
    </title>

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

            @yield('content')

        </main>

        {{-- FOOTER --}}
        @include('composants.pied-page.footer')

    </div>

</body>

</html>
