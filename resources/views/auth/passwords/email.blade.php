@extends('layouts.app')

@section('title', 'Récupération de mot de passe - Artisan Market')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 via-white to-orange-50 flex items-center justify-center py-12 px-4">
    <div class="w-full max-w-md">
        
        {{-- Back button --}}
        <div class="mb-6">
            <a href="{{ route('login') }}" class="inline-flex items-center text-sm font-semibold text-amber-600 hover:text-amber-700 transition gap-2">
                ← Retour à la connexion
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl p-8 border border-[#EFE7DD]">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-extrabold text-amber-600">
                    ArtisanMarket
                </h1>
                <h2 class="text-xl font-bold text-gray-800 mt-4">
                    Mot de passe oublié ?
                </h2>
                <p class="text-gray-500 mt-2 text-sm">
                    Saisissez votre adresse e-mail pour recevoir un lien de réinitialisation.
                </p>
            </div>

            @if (session('status'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700">
                        Adresse Email
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autocomplete="email" 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none text-sm @error('email') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror"
                        placeholder="votre@email.com"
                    >

                    @error('email')
                        <span class="block mt-2 text-xs font-semibold text-rose-600" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-amber-600 hover:bg-amber-700 text-white py-3 rounded-xl font-semibold transition text-sm shadow-sm hover:shadow"
                >
                    Envoyer le lien de réinitialisation
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
