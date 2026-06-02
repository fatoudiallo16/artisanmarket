@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto p-6">

    <div class="mb-6">

        <h1 class="text-3xl font-bold text-gray-800">
            Modifier la catégorie
        </h1>

        <p class="text-gray-500">
            Mettre à jour les informations de la catégorie.
        </p>

    </div>

    <div class="bg-white rounded-2xl shadow p-6">

        <form action="{{ route('admin.categories.update', $category) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">

            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nom
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="4"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3">{{ old('description', $category->description) }}</textarea>
            </div>

            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Image actuelle
                </label>

                @if($category->image)
                    <img
                        src="{{ asset('storage/'.$category->image) }}"
                        class="w-32 h-32 object-cover rounded-xl mb-4">
                @endif

                <input
                    type="file"
                    name="image"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3">

            </div>

            <div>

                <label class="flex items-center gap-3">

                    <input
                        type="checkbox"
                        name="status"
                        value="1"
                        {{ $category->status ? 'checked' : '' }}>

                    <span>
                        Catégorie active
                    </span>

                </label>

            </div>

            <div class="flex gap-4">

                <button
                    type="submit"
                    class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-xl">

                    Mettre à jour

                </button>

                <a href="{{ route('admin.categories.index') }}"
                   class="bg-gray-200 px-6 py-3 rounded-xl">

                    Annuler

                </a>

            </div>

        </form>

    </div>

</div>

@endsection
