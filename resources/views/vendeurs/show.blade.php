@extends('layouts.app')

@section('title', 'Demande vendeur - Artisan Market')

@section('content')
@php($profile = $vendeur->user->vendeurProfile ?? null)
<section class="am-dashboard">
    <div class="container am-container">
        <div class="am-dashboard-hero mb-4">
            <h1 class="am-section-title mb-2">{{ $vendeur->nom_boutique }}</h1>
            <p class="mb-0" style="color:rgba(255,255,255,.82);">Demande de {{ $vendeur->user->name ?? $vendeur->name }}.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="am-panel">
                    <h2 class="h3 fw-bold mb-3">Informations</h2>
                    <p><strong>Email:</strong> {{ $vendeur->user->email ?? 'Non renseigne' }}</p>
                    <p><strong>Telephone:</strong> {{ $profile->telephone ?? 'Non renseigne' }}</p>
                    <p><strong>Adresse:</strong> {{ $profile->adresse ?? 'Non renseignee' }}</p>
                    <p><strong>Description:</strong><br>{{ $profile->description_boutique ?? 'Aucune description.' }}</p>
                    <p><strong>Statut actuel:</strong> <span class="badge text-bg-secondary">{{ $vendeur->statut }}</span></p>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="am-panel">
                    <h2 class="h3 fw-bold mb-3">Decision admin</h2>
                    <form method="POST" action="{{ route('admin.vendeurs.update', $vendeur) }}" class="d-grid gap-3">
                        @csrf
                        @method('PUT')
                        <div class="am-field">
                            <label for="statut">Statut</label>
                            <select id="statut" name="statut">
                                @foreach(['en_attente' => 'En attente', 'approuve' => 'Approuve', 'rejete' => 'Rejete', 'suspendu' => 'Suspendu'] as $value => $label)
                                    <option value="{{ $value }}" @selected($vendeur->statut === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn am-btn-primary" type="submit">Enregistrer la decision</button>
                    </form>

                    <form method="POST" action="{{ route('admin.vendeurs.destroy', $vendeur) }}" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit">Supprimer la demande</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
