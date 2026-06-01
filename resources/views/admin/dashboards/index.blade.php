@extends('layouts.app')

@section('content')

<div class="bg-gray-50 min-h-screen">

    <div class="max-w-7xl mx-auto px-4 py-8">

        <div class="mb-8">

            <h1 class="text-3xl font-bold">
                Dashboard Administrateur
            </h1>

            <p class="text-gray-500">
                Gestion globale de la plateforme ArtisanMarket.
            </p>

        </div>

        <!-- Statistiques -->

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

            <div class="bg-white rounded-2xl p-6 shadow">

                <p class="text-gray-500">
                    Utilisateurs
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    {{ $usersCount }}
                </h2>

            </div>

            <div class="bg-white rounded-2xl p-6 shadow">

                <p class="text-gray-500">
                    Produits
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    {{ $productsCount }}
                </h2>

            </div>

            <div class="bg-white rounded-2xl p-6 shadow">

                <p class="text-gray-500">
                    Catégories
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    {{ $categoriesCount }}
                </h2>

            </div>

            <div class="bg-white rounded-2xl p-6 shadow">

                <p class="text-gray-500">
                    Produits à valider
                </p>

                <h2 class="text-3xl font-bold text-yellow-500 mt-2">
                    {{ $pendingProducts }}
                </h2>

            </div>

        </div>

        <!-- Actions rapides -->

        <div class="bg-white rounded-2xl p-6 shadow mb-10">

            <h2 class="text-xl font-semibold mb-5">

                Administration

            </h2>

            <div class="grid md:grid-cols-4 gap-4">

                <a href="#"
                   class="border rounded-xl p-5 hover:bg-amber-50">

                    👥 Utilisateurs

                </a>

                <a href="#"
                   class="border rounded-xl p-5 hover:bg-amber-50">

                    🏪 Vendeurs

                </a>

                <a href="#"
                   class="border rounded-xl p-5 hover:bg-amber-50">

                    📦 Produits

                </a>

                <a href="#"
                   class="border rounded-xl p-5 hover:bg-amber-50">

                    📋 Commandes

                </a>

            </div>

        </div>

        <!-- Produits récents -->

        <div class="bg-white rounded-2xl p-6 shadow">

            <h2 class="text-xl font-semibold mb-6">

                Derniers produits

            </h2>

            <table class="w-full">

                <thead>

                    <tr class="border-b">

                        <th class="text-left py-3">
                            Produit
                        </th>

                        <th class="text-left py-3">
                            Prix
                        </th>

                        <th class="text-left py-3">
                            Statut
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($recentProducts as $product)

                        <tr class="border-b">

                            <td class="py-4">
                                {{ $product->name }}
                            </td>

                            <td>
                                {{ number_format($product->price,0,' ',' ') }}
                                FCFA
                            </td>

                            <td>

                                @if($product->status == 'approved')

                                    <span class="text-green-600">
                                        Approuvé
                                    </span>

                                @elseif($product->status == 'pending')

                                    <span class="text-yellow-600">
                                        En attente
                                    </span>

                                @else

                                    <span class="text-red-600">
                                        Refusé
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection