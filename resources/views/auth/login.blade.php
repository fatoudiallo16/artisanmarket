@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-orange-50">

    <div class="container mx-auto px-6">

        <div class="grid lg:grid-cols-2 min-h-screen items-center gap-12">

            <!-- Illustration -->
            <div class="hidden lg:flex justify-center">

                <div class="max-w-lg">

                    <img
                        src="{{ asset('images/artisan-login.png') }}"
                        alt="ArtisanMarket"
                        class="w-full">

                    <div class="mt-8">
                        <h2 class="text-4xl font-bold text-gray-800">
                            Valorisez l'artisanat local
                        </h2>

                        <p class="mt-4 text-gray-600">
                            Découvrez des créations uniques réalisées par des artisans passionnés.
                        </p>
                    </div>

                </div>

            </div>

            <!-- Formulaire -->
            <div class="flex justify-center">

                <div class="w-full max-w-md">

                    <div class="bg-white rounded-3xl shadow-xl p-8">

                        <div class="text-center mb-8">

                            <h1 class="text-3xl font-extrabold text-amber-600">
                                ArtisanMarket
                            </h1>

                            <p class="text-gray-500 mt-2">
                                Connectez-vous à votre compte
                            </p>

                        </div>

                        <form
                            method="POST"
                            action="{{ route('login') }}"
                            class="space-y-5">

                            @csrf

                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"
                                    placeholder="votre@email.com">
                            </div>

                            <div
                                x-data="{ show:false }">

                                <label class="block mb-2 text-sm font-medium text-gray-700">
                                    Mot de passe
                                </label>

                                <div class="relative">

                                    <input
                                        :type="show ? 'text' : 'password'"
                                        name="password"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"
                                        placeholder="********">

                                    <button
                                        type="button"
                                        @click="show = !show"
                                        class="absolute right-4 top-3 text-gray-500">

                                        <span x-show="!show">
                                            👁️
                                        </span>

                                        <span x-show="show">
                                            🙈
                                        </span>

                                    </button>

                                </div>

                            </div>

                            <div class="flex justify-between items-center">

                                <label class="flex items-center gap-2">

                                    <input
                                        type="checkbox"
                                        class="rounded text-amber-600">

                                    <span class="text-sm text-gray-600">
                                        Se souvenir de moi
                                    </span>

                                </label>

                                <a
                                    href="#"
                                    class="text-sm text-amber-600 hover:underline">

                                    Mot de passe oublié ?
                                </a>

                            </div>

                            <button
                                type="submit"
                                class="w-full bg-amber-600 hover:bg-amber-700 text-white py-3 rounded-xl font-semibold transition">

                                Se connecter

                            </button>
                            <div class="mt-4 text-red-500">
                                @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                @endforeach
                            </div>

                        </form>

                        <div class="mt-6 text-center">

                            <p class="text-gray-600">
                                Pas encore de compte ?

                                <a
                                    href="{{ route('register') }}"
                                    class="text-amber-600 font-semibold hover:underline">

                                    Inscription

                                </a>
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
@endsection