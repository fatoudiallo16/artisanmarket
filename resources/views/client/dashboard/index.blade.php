@extends('layouts.app')

@section('content')

<div class="bg-gray-50 min-h-screen">

    <div class="max-w-7xl mx-auto px-4 py-8">

        <!-- Titre -->
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-gray-800">
                Bonjour, {{ auth()->user()->name }} 👋
            </h1>

            <p class="text-gray-500 mt-2">
                Bienvenue sur votre espace client.
            </p>

        </div>

        <!-- Statistiques -->

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-gray-500">
                    Mes commandes
                </h3>

                <p class="text-3xl font-bold mt-2">
                    {{ $commandesCount }}
                </p>

            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-gray-500">
                    Articles dans le panier
                </h3>

                <p class="text-3xl font-bold mt-2">
                    {{ $cartCount }}
                </p>

            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-gray-500">
                    Total dépensé
                </h3>

                <p class="text-3xl font-bold mt-2 text-amber-600">
                    {{ App\Helpers\OrderHelper::formatAmount($totalDepense) }}
                </p>

            </div>

        </div>

        <!-- Actions rapides -->

        <div class="bg-white rounded-2xl shadow-sm p-6 mb-10">

            <h2 class="text-xl font-semibold mb-5">
                Actions rapides
            </h2>

            <div class="grid md:grid-cols-3 gap-4">

                <a href="{{ route('produits.index') }}"
                   class="p-4 border rounded-xl hover:bg-amber-50 transition">

                    🛍️ Parcourir les produits

                </a>

                <a href="{{ route('panier.index') }}"
                   class="p-4 border rounded-xl hover:bg-amber-50 transition">

                    🛒 Voir mon panier

                </a>

                <a href="{{ route('commandes.index') }}"
                   class="p-4 border rounded-xl hover:bg-amber-50 transition">

                    📦 Mes commandes

                </a>

            </div>

        </div>

        <!-- Dernières commandes -->

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <div class="flex justify-between items-center mb-6">

                <h2 class="text-xl font-semibold">
                    Dernières commandes
                </h2>

                <a href="{{ route('commandes.index') }}"
                   class="text-amber-600 font-medium">

                    Voir tout
                </a>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>

                        <tr class="border-b">

                            <th class="text-left py-3">
                                Référence
                            </th>

                            <th class="text-left py-3">
                                Date
                            </th>

                            <th class="text-left py-3">
                                Montant
                            </th>

                            <th class="text-left py-3">
                                Statut
                            </th>

                        </tr>

                    </thead>

                    <tbody>
                        @forelse($recentCommandes as $commande)
                            <tr class="border-b last:border-0 hover:bg-gray-50">
                                <td class="py-4">
                                    <a href="{{ route('commandes.show', $commande) }}" class="text-amber-600 font-medium hover:underline">
                                        #CMD-{{ str_pad($commande->id, 5, '0', STR_PAD_LEFT) }}
                                    </a>
                                </td>
                                <td class="py-4 text-gray-500">
                                    {{ $commande->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-4 font-medium">
                                    @php
                                        $total = $commande->lignecommandes->sum(fn($l) => $l->quantite * $l->prix_unitaire);
                                    @endphp
                                    {{ App\Helpers\OrderHelper::formatAmount($total) }}
                                </td>
                                <td class="py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        {{ App\Helpers\OrderHelper::formatStatus($commande->statut->value) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-gray-500">
                                    Aucune commande pour le moment.
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