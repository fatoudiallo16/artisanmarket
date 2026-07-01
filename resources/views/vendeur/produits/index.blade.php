@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Mes produits
            </h1>
            <p class="text-gray-500">
                Gerez vos produits artisanaux.
            </p>
        </div>

        <a href="{{ route('vendeur.produits.create') }}"
           class="bg-amber-600 hover:bg-amber-700 text-white px-5 py-3 rounded-xl font-semibold">
            Ajouter un produit
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[860px]">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 text-left">Image</th>
                        <th class="p-4 text-left">Produit</th>
                        <th class="p-4 text-left">Categorie</th>
                        <th class="p-4 text-left">Prix</th>
                        <th class="p-4 text-left">Stock</th>
                        <th class="p-4 text-left">Statut</th>
                        <th class="p-4 text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse(($produits ?? $products) as $produit)
                        @php
                            $status = $produit->status ?? 'pending';
                            $categoryName = $produit->categorie?->name ?? 'Artisanat';
                        @endphp

                        <tr class="border-b">
                            <td class="p-4">
                                <img
                                    src="{{ $produit->image_url }}"
                                    alt="{{ $produit->nom }}"
                                    class="w-16 h-16 rounded-lg object-cover"
                                >
                            </td>

                            <td class="p-4 font-semibold">
                                {{ $produit->nom }}
                            </td>

                            <td class="p-4">
                                {{ ucfirst($categoryName) }}
                            </td>

                            <td class="p-4">
                                {{ number_format((float) $produit->prix, 0, ' ', ' ') }} FCFA
                            </td>

                            <td class="p-4">
                                {{ $produit->stock }}
                            </td>

                            <td class="p-4">
                                @if($status === 'approved')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Approuve</span>
                                @elseif($status === 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">En attente</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">Refuse</span>
                                @endif
                            </td>

                            <td class="p-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('vendeur.produits.show', $produit) }}"
                                       class="bg-blue-500 text-white px-3 py-2 rounded-lg">
                                        Voir
                                    </a>

                                    <a href="{{ route('vendeur.produits.edit', $produit) }}"
                                       class="bg-amber-500 text-white px-3 py-2 rounded-lg">
                                        Modifier
                                    </a>

                                    <form
                                        action="{{ route('vendeur.produits.destroy', $produit) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            onclick="return confirm('Supprimer ce produit ?')"
                                            class="bg-red-500 text-white px-3 py-2 rounded-lg">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-gray-500">
                                Aucun produit trouve.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ ($produits ?? $products)->links() }}
    </div>
</div>
@endsection
