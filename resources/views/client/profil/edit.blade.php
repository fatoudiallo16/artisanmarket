@extends('layouts.app')

@section('content')

<div class="bg-gray-50 min-h-screen">

    <div class="max-w-5xl mx-auto py-10 px-4">

        <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

            <!-- Header -->

            <div class="bg-amber-600 h-40"></div>

            <div class="px-8 pb-8">

                <div class="-mt-16 flex flex-col md:flex-row md:items-end gap-6">

                    <div>

                        <img
                            src="{{ $user->photo ? asset('storage/'.$user->photo) : asset('images/default-user.png') }}"
                            class="w-32 h-32 rounded-full border-4 border-white object-cover">

                    </div>

                    <div>

                        <h1 class="text-3xl font-bold text-gray-800">

                            {{ $user->name }}

                        </h1>

                        <p class="text-gray-500">

                            {{ $user->email }}

                        </p>

                    </div>

                </div>

                <!-- Informations -->

                <div class="grid md:grid-cols-2 gap-6 mt-10">

                    <div class="bg-gray-50 p-5 rounded-2xl">

                        <h3 class="font-semibold text-gray-700 mb-3">

                            Informations personnelles

                        </h3>

                        <p>
                            <strong>Nom :</strong>
                            {{ $user->name }}
                        </p>

                        <p class="mt-2">
                            <strong>Email :</strong>
                            {{ $user->email }}
                        </p>

                        <p class="mt-2">
                            <strong>Téléphone :</strong>
                            {{ $user->phone ?? 'Non renseigné' }}
                        </p>

                    </div>

                    <div class="bg-gray-50 p-5 rounded-2xl">

                        <h3 class="font-semibold text-gray-700 mb-3">

                            Compte

                        </h3>

                        <p>
                            <strong>Rôle :</strong>
                            {{ $user->role->nom_role }}
                        </p>

                        <p class="mt-2">
                            <strong>Membre depuis :</strong>
                            {{ $user->created_at->format('d/m/Y') }}
                        </p>

                    </div>

                </div>

                <!-- Boutons -->

                <div class="flex gap-4 mt-8">

                    <a href="#"
                       class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-xl">

                        Modifier le profil

                    </a>

                    <a href="#"
                       class="bg-gray-200 hover:bg-gray-300 px-6 py-3 rounded-xl">

                        Changer le mot de passe

                    </a>

                </div>

                <!-- Zone de danger (Suppression de compte) -->
                <div class="mt-12 border-t border-rose-100 pt-8">
                    <h3 class="text-lg font-bold text-rose-700 mb-2 flex items-center gap-2">
                        ⚠️ Zone de danger
                    </h3>
                    <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                        Si vous supprimez votre compte, toutes vos informations personnelles, vos produits mis en vente (si vous êtes vendeur) et vos commandes associées seront définitivement supprimés de la plateforme. Cette action est irréversible.
                    </p>
                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Êtes-vous absolument sûr de vouloir supprimer votre compte définitivement ? Cette action est irréversible.');">
                        @csrf
                        @method('DELETE')

                        <div class="mb-4">
                            <label for="delete-password" class="block text-sm font-medium text-gray-700 mb-1">
                                Confirmez votre mot de passe
                            </label>
                            <input
                                type="password"
                                name="password"
                                id="delete-password"
                                required
                                class="w-full md:w-80 px-4 py-2 border border-gray-300 rounded-xl focus:ring-rose-500 focus:border-rose-500 @error('password') border-rose-500 @enderror"
                                placeholder="Votre mot de passe actuel"
                            >
                            @error('password')
                                <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-sm shadow-sm hover:shadow transition duration-200">
                            Supprimer mon compte
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection