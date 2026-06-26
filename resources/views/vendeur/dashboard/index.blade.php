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

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-10">

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#EFE7DD]">
                <p class="text-gray-500 text-sm font-medium">Produits</p>
                <h2 class="text-3xl font-black mt-2 text-slate-800">{{ $productsCount ?? 0 }}</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#EFE7DD]">
                <p class="text-gray-500 text-sm font-medium">Approuvés</p>
                <h2 class="text-3xl font-black text-emerald-600 mt-2">{{ $approvedProducts ?? 0 }}</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#EFE7DD]">
                <p class="text-gray-500 text-sm font-medium">En attente</p>
                <h2 class="text-3xl font-black text-amber-500 mt-2">{{ $pendingProducts ?? 0 }}</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#EFE7DD]">
                <p class="text-gray-500 text-sm font-medium">Ventes</p>
                <h2 class="text-3xl font-black text-blue-600 mt-2">{{ $salesCount ?? 0 }}</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#EFE7DD]">
                <p class="text-gray-500 text-sm font-medium">Articles vendus</p>
                <h2 class="text-3xl font-black text-indigo-600 mt-2">{{ $productsSold ?? 0 }}</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#EFE7DD]">
                <p class="text-gray-500 text-sm font-medium">Revenus</p>
                <h2 class="text-3xl font-black text-[#D86513] mt-2">
                    {{ number_format($revenue ?? 0,0,' ',' ') }}
                    <span class="text-xs font-bold">FCFA</span>
                </h2>
            </div>

        </div>

        <!-- Actions rapides -->

        <div class="bg-white rounded-2xl shadow-sm p-6 mb-10">

            <h2 class="text-xl font-semibold mb-5">

                Actions rapides

            </h2>

            <div class="grid md:grid-cols-3 gap-4">

                <a href="{{ route('vendeur.produits.create') }}"
                   class="border rounded-xl p-5 hover:bg-amber-50 transition duration-150">

                    ➕ Ajouter un produit

                </a>

                <a href="{{ route('vendeur.produits.index') }}"
                   class="border rounded-xl p-5 hover:bg-amber-50 transition duration-150">

                    📦 Mes produits

                </a>

                <a href="#sales-section"
                   class="border rounded-xl p-5 hover:bg-amber-50 transition duration-150">

                    📈 Voir les ventes

                </a>

            </div>

        </div>

        <!-- Suivi des ventes -->

        <div id="sales-section" class="bg-white rounded-2xl shadow-sm p-6 mb-10 scroll-mt-24 border border-[#EFE7DD]">

            <div class="flex justify-between items-center mb-6">

                <h2 class="text-xl font-semibold">

                    Suivi récent des ventes

                </h2>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>

                        <tr class="border-b text-slate-400 font-semibold text-xs uppercase tracking-wider pb-3">

                            <th class="text-left py-3">
                                Référence
                            </th>

                            <th class="text-left py-3">
                                Date
                            </th>

                            <th class="text-left py-3">
                                Client
                            </th>

                            <th class="text-left py-3">
                                Produit
                            </th>

                            <th class="text-center py-3">
                                Quantité
                            </th>

                            <th class="text-right py-3">
                                Total
                            </th>

                            <th class="text-right py-3">
                                Statut
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-[#FAF7F2] text-sm">

                        @forelse($recentSales ?? [] as $sale)

                            <tr class="hover:bg-[#FAF7F2]/40 transition-colors duration-150">

                                <td class="py-4 font-bold text-[#D86513]">

                                    #{{ $sale->commande_id }}

                                </td>

                                <td class="text-slate-600">

                                    {{ $sale->commande->created_at?->format('d/m/Y H:i') }}

                                </td>

                                <td class="text-slate-700 font-medium">

                                    {{ $sale->commande->user->name ?? 'Client inconnu' }}

                                </td>

                                <td class="text-slate-700 font-medium">

                                    {{ $sale->produit->nom ?? 'Produit archivé' }}

                                </td>

                                <td class="text-center font-semibold text-slate-700">

                                    {{ $sale->quantite }}

                                </td>

                                <td class="text-right font-bold text-slate-900">

                                    {{ number_format((float) ($sale->quantite * $sale->prix_unitaire), 0, ',', ' ') }} FCFA

                                </td>

                                <td class="text-right">

                                    @if($sale->commande->statut === 'en_attente')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200/50">
                                            En attente
                                        </span>
                                    @elseif($sale->commande->statut === 'en_cours')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/50">
                                            En cours
                                        </span>
                                    @elseif($sale->commande->statut === 'payee')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200/50">
                                            Payée
                                        </span>
                                    @elseif($sale->commande->statut === 'annulee')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200/50">
                                            Annulée
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-50 text-slate-700 border border-slate-200/50">
                                            {{ ucfirst(str_replace('_', ' ', $sale->commande->statut)) }}
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center py-8 text-gray-500">

                                    Aucune vente enregistrée.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <!-- Produits récents -->

        <div class="bg-white rounded-2xl shadow-sm p-6">

            <div class="flex justify-between items-center mb-6">

                <h2 class="text-xl font-semibold">

                    Produits récents

                </h2>

                <a href="{{ route('vendeur.produits.index') }}"
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

                                    {{ $product->nom }}

                                </td>

                                <td>

                                    {{ number_format((float) $product->prix,0,' ',' ') }}

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
