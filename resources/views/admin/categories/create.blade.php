@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto p-6">

    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Nouvelle catégorie
        </h1>

        <p class="text-gray-500">
            Ajouter une catégorie de produits.
        </p>

    </div>

    <div class="bg-white rounded-2xl shadow p-6">

        <form action="{{ route('categories.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf

            <!-- Nom -->

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nom de la catégorie
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                    placeholder="Ex : Bijoux">

                @error('name')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Description -->

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-amber-500 focus:border-amber-500"
                    placeholder="Description de la catégorie">{{ old('description') }}</textarea>

            </div>

            <!-- Image -->

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Image
                </label>

                <input
                    type="file"
                    name="image"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3">

                @error('image')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Statut -->

            <div>

                <label class="flex items-center gap-3">

                    <input
                        type="checkbox"
                        name="status"
                        value="1"
                        checked
                        class="rounded text-amber-600">

                    <span class="text-gray-700">
                        Catégorie active
                    </span>

                </label>

            </div>

            <!-- Boutons -->

            <div class="flex gap-4">

                <button
                    type="submit"
                    class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-xl">

                    Enregistrer

                </button>

                <a href="{{ route('categories.index') }}"
                   class="bg-gray-200 hover:bg-gray-300 px-6 py-3 rounded-xl">

                    Annuler

                </a>

            </div>

        </form>

    </div>

</div>

@endsection