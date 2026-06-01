@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto p-6">

    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">
                Mes Produits
            </h1>

            <p class="text-gray-500">
                Gérez vos produits artisanaux.
            </p>

        </div>

        <a href="{{ route('products.create') }}"
           class="bg-amber-600 hover:bg-amber-700 text-white px-5 py-3 rounded-xl">

            + Ajouter un produit

        </a>

    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">Image</th>
                    <th class="p-4 text-left">Produit</th>
                    <th class="p-4 text-left">Catégorie</th>
                    <th class="p-4 text-left">Prix</th>
                    <th class="p-4 text-left">Stock</th>
                    <th class="p-4 text-left">Statut</th>
                    <th class="p-4 text-center">Actions</th>

                </tr>

            </thead>

            <tbody>

                @forelse($products as $product)

                <tr class="border-b">

                    <td class="p-4">

                        @if($product->images->count())

                            <img
                                src="{{ asset('storage/'.$product->images->first()->image) }}"
                                class="w-16 h-16 rounded-lg object-cover">

                        @endif

                    </td>

                    <td class="p-4 font-semibold">
                        {{ $product->name }}
                    </td>

                    <td class="p-4">
                        {{ $product->category->name }}
                    </td>

                    <td class="p-4">
                        {{ number_format($product->price,0,' ',' ') }} FCFA
                    </td>

                    <td class="p-4">
                        {{ $product->stock }}
                    </td>

                    <td class="p-4">

                        @if($product->status == 'approved')

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Approuvé
                            </span>

                        @elseif($product->status == 'pending')

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                En attente
                            </span>

                        @else

                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                Refusé
                            </span>

                        @endif

                    </td>

                    <td class="p-4">

                        <div class="flex justify-center gap-2">

                            <a href="{{ route('products.show',$product) }}"
                               class="bg-blue-500 text-white px-3 py-2 rounded-lg">
                                Voir
                            </a>

                            <a href="{{ route('products.edit',$product) }}"
                               class="bg-amber-500 text-white px-3 py-2 rounded-lg">
                                Modifier
                            </a>

                            <form
                                action="{{ route('products.destroy',$product) }}"
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

                    <td colspan="7"
                        class="text-center py-10 text-gray-500">

                        Aucun produit trouvé.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-6">

        {{ $products->links() }}

    </div>

</div>

@endsection