@extends('layouts.app')

@section('title', 'Tableau client - Artisan Market')

@section('content')
<section class="am-dashboard">
    <div class="container am-container">
        <div class="am-dashboard-hero mb-4">
            <p class="text-uppercase fw-bold mb-2" style="color:#f5dfb5;">Espace client</p>
            <h1 class="am-section-title mb-2">Bonjour {{ Auth::user()->name }}</h1>
            <p class="mb-0" style="max-width:720px;color:rgba(255,255,255,.82);">Suivez vos achats, explorez les nouveautes et envoyez une demande pour ouvrir votre boutique Artisan Market.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-5">
                <div class="am-panel h-100">
                    <h2 class="h3 fw-bold mb-3">Devenir vendeur</h2>
                    @if($demande)
                        <p class="text-muted">Votre demande pour <strong>{{ $demande->nom_boutique }}</strong> est actuellement:</p>
                        <span class="badge text-bg-{{ $demande->statut === 'approuve' ? 'success' : ($demande->statut === 'rejete' ? 'danger' : 'warning') }}">{{ ucfirst(str_replace('_', ' ', $demande->statut)) }}</span>
                    @else
                        <form method="POST" action="{{ route('vendeur.request') }}" class="d-grid gap-3">
                            @csrf
                            <div class="am-field">
                                <label for="nom_boutique">Nom de la boutique</label>
                                <input id="nom_boutique" name="nom_boutique" value="{{ old('nom_boutique') }}" required>
                            </div>
                            <div class="am-field">
                                <label for="description_boutique">Description</label>
                                <textarea id="description_boutique" name="description_boutique">{{ old('description_boutique') }}</textarea>
                            </div>
                            <div class="am-form-grid">
                                <div class="am-field">
                                    <label for="telephone">Telephone</label>
                                    <input id="telephone" name="telephone" value="{{ old('telephone') }}">
                                </div>
                                <div class="am-field">
                                    <label for="adresse">Adresse</label>
                                    <input id="adresse" name="adresse" value="{{ old('adresse') }}">
                                </div>
                            </div>
                            <button class="btn am-btn-primary" type="submit">Envoyer la demande</button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="col-lg-7">
                <div class="am-panel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h3 fw-bold mb-0">Nouveaux produits</h2>
                        <a class="fw-bold" href="{{ route('produits.index') }}">Catalogue</a>
                    </div>
                    @include('produits.partials.grid', ['produits' => $produits])
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
