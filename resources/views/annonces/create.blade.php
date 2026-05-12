@extends('layouts.app')

@section('title', 'Nouvelle annonce - Artisan Market')

@section('content')
<section class="am-dashboard">
    <div class="container am-container">
        <div class="am-dashboard-hero mb-4">
            <h1 class="am-section-title mb-2">Nouvelle annonce</h1>
            <p class="mb-0" style="color:rgba(255,255,255,.82);">Promotions, evenements et actualites visibles par tous les visiteurs.</p>
        </div>

        <div class="am-panel">
            <form method="POST" action="{{ route('admin.annonces.store') }}" enctype="multipart/form-data" class="d-grid gap-3">
                @csrf
                <div class="am-field">
                    <label for="titre">Titre</label>
                    <input id="titre" name="titre" value="{{ old('titre') }}" required>
                </div>
                <div class="am-field">
                    <label for="contenu">Contenu</label>
                    <textarea id="contenu" name="contenu" required>{{ old('contenu') }}</textarea>
                </div>
                <div class="am-field">
                    <label for="image">Image</label>
                    <input id="image" name="image" type="file" accept="image/*">
                </div>
                <button class="btn am-btn-primary" type="submit">Publier</button>
            </form>
        </div>
    </div>
</section>
@endsection
