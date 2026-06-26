@extends('layouts.app')

@section('title', 'Réinitialisation de mot de passe - Artisan Market')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-orange-50 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        
        <div class="bg-white rounded-3xl shadow-xl p-8 border border-[#EFE7DD]">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-amber-600">
                    ArtisanMarket
                </h1>
                <h2 class="text-xl font-bold text-gray-800 mt-4">
                    Nouveau mot de passe
                </h2>
                <p class="text-gray-500 mt-2 text-sm">
                    Définissez votre nouveau mot de passe de connexion.
                </p>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700">
                        Adresse Email
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ $email ?? old('email') }}" 
                        required 
                        autocomplete="email" 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none text-sm @error('email') border-rose-500 focus:ring-rose-500 @enderror"
                    >

                    @error('email')
                        <span class="block mt-2 text-xs font-semibold text-rose-600" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-700">
                        Nouveau mot de passe
                    </label>
                    <input 
                        id="password" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="new-password"
                        placeholder="Min. 8 caractères"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none text-sm @error('password') border-rose-500 focus:ring-rose-500 @enderror"
                    >

                    @error('password')
                        <span class="block mt-2 text-xs font-semibold text-rose-600" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div>
                    <label for="password-confirm" class="block mb-2 text-sm font-medium text-gray-700">
                        Confirmer le mot de passe
                    </label>
                    <input 
                        id="password-confirm" 
                        type="password" 
                        name="password_confirmation" 
                        required 
                        autocomplete="new-password"
                        placeholder="Ressaisissez le mot de passe"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none text-sm"
                    >
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-amber-600 hover:bg-amber-700 text-white py-3 rounded-xl font-semibold transition text-sm shadow-sm hover:shadow mt-2"
                >
                    Réinitialiser le mot de passe
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
