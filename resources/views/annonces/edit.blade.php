@extends('layouts.app')

@section('title', 'Modifier une annonce - Artisan Market')

@section('content')
<section class="am-dashboard">
    <div class="container am-container">
        <div class="am-dashboard-hero mb-4">
            <h1 class="am-section-title mb-2">Modifier l'annonce</h1>
        </div>

        <div class="am-panel">
            <form method="POST" action="{{ route('admin.annonces.update', $annonce) }}" enctype="multipart/form-data" class="d-grid gap-3">
                @csrf
                @method('PUT')
                <div class="am-field">
                    <label for="titre">Titre</label>
                    <input id="titre" name="titre" value="{{ old('titre', $annonce->titre) }}" required>
                </div>
                <div class="am-field">
                    <label for="contenu">Contenu</label>
                    <textarea id="contenu" name="contenu" required>{{ old('contenu', $annonce->contenu) }}</textarea>
                </div>
                <div class="am-field">
                    <label for="image">Changer l'image</label>
                    <input id="image" name="image" type="file" accept="image/*">
                </div>
                <button class="btn am-btn-primary" type="submit">Enregistrer</button>
            </form>
        </div>
    </div>
</section>
@endsection
