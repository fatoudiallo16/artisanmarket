@extends('layouts.app')

@section('content')

<div class="bg-gray-50 min-h-screen">

    <div class="max-w-7xl mx-auto px-4 py-8">

        <!-- Header -->

        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-800">
                Tableau de bord vendeur
            </h1>

            <p class="text-gray-500 mt-2">
                Gérez vos produits et suivez vos performances.
            </p>

        </div>

        <!-- Statistiques -->

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

            <div class="bg-white p-6 rounded-2xl shadow-sm">

                <p class="text-gray-500">
                    Produits
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    {{ $productsCount ?? 0 }}
                </h2>

            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm">

                <p class="text-gray-500">
                    Produits approuvés
                </p>

                <h2 class="text-3xl font-bold text-green-600 mt-2">
                    {{ $approvedProducts ?? 0 }}
                </h2>

            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm">

                <p class="text-gray-500">
                    En attente
                </p>

                <h2 class="text-3xl font-bold text-yellow-500 mt-2">
                    {{ $pendingProducts ?? 0 }}
                </h2>

            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm">

                <p class="text-gray-500">
                    Revenus
                </p>

                <h2 class="text-3xl font-bold text-amber-600 mt-2">
                    {{ number_format($revenue ?? 0,0,' ',' ') }}
                    FCFA
                </h2>

            </div>

        </div>

        <!-- Actions rapides -->

        <div class="bg-white rounded-2xl shadow-sm p-6 mb-10">

            <h2 class="text-xl font-semibold mb-5">

                Actions rapides

            </h2>

            <div class="grid md:grid-cols-3 gap-4">

                <a href="{{ route('products.create') }}"
                   class="border rounded-xl p-5 hover:bg-amber-50">

                    ➕ Ajouter un produit

                </a>

                <a href="{{ route('products.index') }}"
                   class="border rounded-xl p-5 hover:bg-amber-50">

                    📦 Mes produits

                </a>

                <a href="#"
                   class="border rounded-xl p-5 hover:bg-amber-50">

                    📈 Voir les ventes

                </a>

            </div>

        </div>

        <!-- Produits récents -->

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <div class="flex justify-between items-center mb-6">

                <h2 class="text-xl font-semibold">

                    Produits récents

                </h2>

                <a href="{{ route('products.index') }}"
                   class="text-amber-600">

                    Voir tout

                </a>

            </div>

            <div class="overflow-x-auto">

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
                                Stock
                            </th>

                            <th class="text-left py-3">
                                Statut
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($recentProducts ?? [] as $product)

                            <tr class="border-b">

                                <td class="py-4">

                                    {{ $product->name }}

                                </td>

                                <td>

                                    {{ number_format($product->price,0,' ',' ') }}

                                    FCFA

                                </td>

                                <td>

                                    {{ $product->stock }}

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

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center py-8 text-gray-500">

                                    Aucun produit trouvé.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection