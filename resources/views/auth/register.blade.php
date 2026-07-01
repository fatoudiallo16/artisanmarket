@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-orange-50">

    <div class="container mx-auto px-6 py-12">

        <div class="max-w-2xl mx-auto">

            <div class="bg-white rounded-3xl shadow-xl p-8">

                <div class="text-center mb-8">

                    <h1 class="text-4xl font-extrabold text-amber-600">
                        ArtisanMarket
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Créez votre compte et rejoignez notre communauté
                    </p>

                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-4">

                       
                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Nom Complet
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"
                                placeholder="Votre nom complet">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Adresse Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"
                            placeholder="email@example.com">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>




                    <div
                        x-data="{ show:false }">

                        <label class="block text-sm font-medium mb-2">
                            Mot de passe
                        </label>

                        <div class="relative">

                            <input
                                :type="show ? 'text' : 'password'"
                                name="password"
                                required
                                minlength="8"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"
                                placeholder="********">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                            <button
                                type="button"
                                @click="show=!show"
                                class="absolute right-4 top-3">

                                👁️

                            </button>

                        </div>

                    </div>

                    <div
                        x-data="{ showConf:false }">

                        <label class="block text-sm font-medium mb-2">
                            Confirmer le mot de passe
                        </label>

                        <div class="relative">

                            <input
                                :type="showConf ? 'text' : 'password'"
                                name="password_confirmation"
                                required
                                minlength="8"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"
                                placeholder="********">

                            <button
                                type="button"
                                @click="showConf=!showConf"
                                class="absolute right-4 top-3">

                                👁️

                            </button>

                        </div>

                    </div>

                    <div class="flex items-start gap-3">

                        <input
                            type="checkbox"
                            required
                            class="mt-1">

                        <span class="text-sm text-gray-600">
                            J'accepte les conditions générales d'utilisation.
                        </span>

                    </div>

                    <button
                        type="submit"
                        class="w-full bg-amber-600 hover:bg-amber-700 text-white py-3 rounded-xl font-semibold transition">

                        Créer mon compte

                    </button>

                </form>

                <div class="text-center mt-6">

                    <p class="text-gray-600">
                        Vous avez déjà un compte ?

                        <a
                            href="{{ route('login') }}"
                            class="text-amber-600 font-semibold hover:underline">

                            Se connecter

                        </a>
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection