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
                    0
                </p>

            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-gray-500">
                    Articles dans le panier
                </h3>

                <p class="text-3xl font-bold mt-2">
                    0
                </p>

            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h3 class="text-gray-500">
                    Total dépensé
                </h3>

                <p class="text-3xl font-bold mt-2 text-amber-600">
                    0 FCFA
                </p>

            </div>

        </div>

        <!-- Actions rapides -->

        <div class="bg-white rounded-2xl shadow-sm p-6 mb-10">

            <h2 class="text-xl font-semibold mb-5">
                Actions rapides
            </h2>

            <div class="grid md:grid-cols-3 gap-4">

                <a href="#"
                   class="p-4 border rounded-xl hover:bg-amber-50 transition">

                    🛍️ Parcourir les produits

                </a>

                <a href="#"
                   class="p-4 border rounded-xl hover:bg-amber-50 transition">

                    🛒 Voir mon panier

                </a>

                <a href="#"
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

                <a href="#"
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

                        <tr>

                            <td colspan="4"
                                class="text-center py-8 text-gray-500">

                                Aucune commande pour le moment.

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection