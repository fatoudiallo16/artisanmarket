@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Catégories
            </h1>

            <p class="text-gray-500">
                Gérez les catégories de produits.
            </p>
        </div>

        <a href="{{ route('categories.create') }}"
           class="bg-amber-600 hover:bg-amber-700 text-white px-5 py-3 rounded-xl">

            + Nouvelle catégorie

        </a>

    </div>

    <div class="bg-white rounded-2xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">
                        Image
                    </th>

                    <th class="p-4 text-left">
                        Nom
                    </th>

                    <th class="p-4 text-left">
                        Description
                    </th>

                    <th class="p-4 text-left">
                        Statut
                    </th>

                    <th class="p-4 text-center">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($categories as $category)

                    <tr class="border-b">

                        <td class="p-4">

                            <img
                                src="{{ asset('storage/'.$category->image) }}"
                                class="w-16 h-16 rounded-lg object-cover">

                        </td>

                        <td class="p-4 font-semibold">

                            {{ $category->name }}

                        </td>

                        <td class="p-4 text-gray-600">

                            {{ \Illuminate\Support\Str::limit($category->description, 50) }}

                        </td>

                        <td class="p-4">

                            @if($category->status)

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                    Actif
                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                    Inactif
                                </span>

                            @endif

                        </td>

                        <td class="p-4">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('categories.show',$category) }}"
                                   class="bg-blue-500 text-white px-3 py-2 rounded-lg">

                                    Voir

                                </a>

                                <a href="{{ route('categories.edit',$category) }}"
                                   class="bg-yellow-500 text-white px-3 py-2 rounded-lg">

                                    Modifier

                                </a>

                                <form action="{{ route('categories.destroy',$category) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Supprimer cette catégorie ?')"
                                        class="bg-red-500 text-white px-3 py-2 rounded-lg">

                                        Supprimer

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="text-center py-10 text-gray-500">

                            Aucune catégorie trouvée.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection