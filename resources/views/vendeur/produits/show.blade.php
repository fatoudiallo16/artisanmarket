@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto p-6">

    <div class="flex justify-between items-center mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                {{ $product->name }}
            </h1>

            <p class="text-gray-500">
                Détails du produit
            </p>
        </div>

        <a href="{{ route('products.index') }}"
           class="bg-gray-200 hover:bg-gray-300 px-5 py-3 rounded-xl">

            Retour

        </a>

    </div>

    <div class="grid lg:grid-cols-2 gap-8">

        <!-- Galerie Images -->

        <div x-data="{ activeImage: '{{ asset('storage/'.$product->images->first()->image ?? '') }}' }">

            <div class="bg-white rounded-2xl shadow p-4">

                <img
                    :src="activeImage"
                    class="w-full h-[500px] object-cover rounded-xl">

            </div>

            <div class="flex gap-3 mt-4 flex-wrap">

                @foreach($product->images as $image)

                    <img
                        src="{{ asset('storage/'.$image->image) }}"
                        @click="activeImage='{{ asset('storage/'.$image->image) }}'"
                        class="w-24 h-24 object-cover rounded-xl cursor-pointer border hover:border-amber-500">

                @endforeach

            </div>

        </div>

        <!-- Informations -->

        <div class="bg-white rounded-2xl shadow p-8">

            <div class="mb-6">

                <span class="text-sm text-gray-500">
                    Catégorie
                </span>

                <h3 class="text-xl font-semibold">
                    {{ $product->category->name }}
                </h3>

            </div>

            <div class="mb-6">

                <span class="text-sm text-gray-500">
                    Prix
                </span>

                <h3 class="text-3xl font-bold text-amber-600">

                    {{ number_format($product->price,0,' ',' ') }}

                    FCFA

                </h3>

            </div>

            <div class="mb-6">

                <span class="text-sm text-gray-500">
                    Stock disponible
                </span>

                <h3 class="text-xl font-semibold">

                    {{ $product->stock }}

                </h3>

            </div>

            <div class="mb-6">

                <span class="text-sm text-gray-500">
                    Statut
                </span>

                <div class="mt-2">

                    @if($product->status == 'approved')

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                            Approuvé
                        </span>

                    @elseif($product->status == 'pending')

                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">
                            En attente
                        </span>

                    @else

                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
                            Refusé
                        </span>

                    @endif

                </div>

            </div>

            <div>

                <span class="text-sm text-gray-500">
                    Description
                </span>

                <p class="mt-2 text-gray-700 leading-relaxed">

                    {{ $product->description }}

                </p>

            </div>

            <div class="flex gap-3 mt-8">

                <a href="{{ route('products.edit', $product) }}"
                   class="bg-amber-600 hover:bg-amber-700 text-white px-5 py-3 rounded-xl">

                    Modifier

                </a>

                <form action="{{ route('products.destroy',$product) }}"
                      method="POST">

                    @csrf
                    @method('DELETE')

                    <button
                        onclick="return confirm('Supprimer ce produit ?')"
                        class="bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-xl">

                        Supprimer

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection