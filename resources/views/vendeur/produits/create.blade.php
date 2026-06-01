@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto p-6">

    <div class="mb-8">

        <h1 class="text-3xl font-bold">
            Ajouter un produit
        </h1>

        <p class="text-gray-500">
            Publiez un nouveau produit artisanal.
        </p>

    </div>

    <div class="bg-white rounded-2xl shadow p-6">

        <form
            action="{{ route('products.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="space-y-6">

            @csrf

            <!-- Nom -->

            <div>

                <label class="block mb-2">
                    Nom du produit
                </label>

                <input
                    type="text"
                    name="name"
                    class="w-full border rounded-xl px-4 py-3">

            </div>

            <!-- Catégorie -->

            <div>

                <label class="block mb-2">
                    Catégorie
                </label>

                <select
                    name="category_id"
                    class="w-full border rounded-xl px-4 py-3">

                    <option value="">
                        Choisir une catégorie
                    </option>

                    @foreach($categories as $category)

                        <option value="{{ $category->id }}">
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            <!-- Prix -->

            <div>

                <label class="block mb-2">
                    Prix (FCFA)
                </label>

                <input
                    type="number"
                    name="price"
                    class="w-full border rounded-xl px-4 py-3">

            </div>

            <!-- Stock -->

            <div>

                <label class="block mb-2">
                    Stock
                </label>

                <input
                    type="number"
                    name="stock"
                    value="1"
                    class="w-full border rounded-xl px-4 py-3">

            </div>

            <!-- Description -->

            <div>

                <label class="block mb-2">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="6"
                    class="w-full border rounded-xl px-4 py-3"></textarea>

            </div>

            <!-- Images -->

            <div>

                <label class="block mb-2">
                    Images du produit
                </label>

                <input
                    type="file"
                    name="images[]"
                    multiple
                    class="w-full border rounded-xl px-4 py-3">

                <p class="text-sm text-gray-500 mt-2">
                    Vous pouvez sélectionner plusieurs images.
                </p>

            </div>

            <button
                type="submit"
                class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-xl">

                Publier le produit

            </button>

        </form>

    </div>

</div>

@endsection