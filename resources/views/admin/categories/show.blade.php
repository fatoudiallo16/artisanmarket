@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto p-6">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                {{ $category->name }}
            </h1>

            <p class="text-gray-500">
                Détails de la catégorie
            </p>
        </div>

        <a href="{{ route('categories.index') }}"
           class="bg-gray-200 px-4 py-2 rounded-xl">
            Retour
        </a>

    </div>

    <div class="bg-white rounded-2xl shadow p-6">

        <div class="grid md:grid-cols-2 gap-8">

            <div>

                @if($category->image)

                    <img
                        src="{{ asset('storage/'.$category->image) }}"
                        class="w-full rounded-2xl object-cover">

                @else

                    <div class="bg-gray-100 h-64 rounded-2xl flex items-center justify-center">
                        Aucune image
                    </div>

                @endif

            </div>

            <div>

                <div class="mb-6">

                    <h3 class="font-semibold text-lg mb-2">
                        Nom
                    </h3>

                    <p>
                        {{ $category->name }}
                    </p>

                </div>

                <div class="mb-6">

                    <h3 class="font-semibold text-lg mb-2">
                        Description
                    </h3>

                    <p class="text-gray-600">
                        {{ $category->description }}
                    </p>

                </div>

                <div class="mb-6">

                    <h3 class="font-semibold text-lg mb-2">
                        Statut
                    </h3>

                    @if($category->status)

                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                            Active
                        </span>

                    @else

                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
                            Inactive
                        </span>

                    @endif

                </div>

                <div class="mb-6">

                    <h3 class="font-semibold text-lg mb-2">
                        Date de création
                    </h3>

                    <p>
                        {{ $category->created_at->format('d/m/Y H:i') }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection