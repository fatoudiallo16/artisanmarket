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
                                Prénom
                            </label>

                            <input
                                type="text"
                                name="first_name"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"
                                placeholder="Votre prénom">
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">
                                Nom
                            </label>

                            <input
                                type="text"
                                name="last_name"
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"
                                placeholder="Votre nom">
                        </div>

                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Adresse Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"
                            placeholder="email@example.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Téléphone
                        </label>

                        <input
                            type="text"
                            name="phone"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"
                            placeholder="+223 XX XX XX XX">
                    </div>

                    <div
                        x-data="{ vendeur: false }">

                        <label class="block text-sm font-medium mb-3">
                            Type de compte
                        </label>

                        <div class="space-y-3">

                            <label
                                class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:bg-gray-50">

                                <input
                                    type="radio"
                                    name="account_type"
                                    value="client"
                                    checked
                                    @click="vendeur=false">

                                <div>
                                    <h3 class="font-semibold">
                                        Client
                                    </h3>

                                    <p class="text-sm text-gray-500">
                                        Acheter des produits artisanaux
                                    </p>
                                </div>

                            </label>

                            <label
                                class="flex items-center gap-3 p-4 border rounded-xl cursor-pointer hover:bg-gray-50">

                                <input
                                    type="radio"
                                    name="account_type"
                                    value="seller"
                                    @click="vendeur=true">

                                <div>
                                    <h3 class="font-semibold">
                                        Demande de compte vendeur
                                    </h3>

                                    <p class="text-sm text-gray-500">
                                        Vendre vos créations sur la plateforme
                                    </p>
                                </div>

                            </label>

                        </div>

                        <div
                            x-show="vendeur"
                            x-transition
                            class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-xl">

                            <p class="text-sm text-amber-800">
                                Votre demande sera examinée par un administrateur avant l'activation du compte vendeur.
                            </p>

                        </div>

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
                                class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"
                                placeholder="********">

                            <button
                                type="button"
                                @click="show=!show"
                                class="absolute right-4 top-3">

                                👁️

                            </button>

                        </div>

                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">
                            Confirmation du mot de passe
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none"
                            placeholder="********">
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