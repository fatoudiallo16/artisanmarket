@extends('layouts.app')

@section('title', 'Annonces - Artisan Market')

@section('content')
<section class="am-page-head">
    <div class="container am-container">
        <h1 class="am-page-title">Annonces</h1>
        @auth
            @if(Auth::user()->hasRole('admin'))
                <a class="btn am-btn-primary mt-3" href="{{ route('admin.annonces.create') }}">Ajouter une annonce</a>
            @endif
        @endauth
        <p class="am-page-lead">Restez informé de nos promotions, événements et actualités</p>
    </div>
</section>

@php
    $fallbackAnnouncements = collect([
        (object) ['id' => 1, 'titre' => 'Promotion Spéciale Bijoux - 20% de Réduction', 'contenu' => "Profitez de 20% de réduction sur tous nos bijoux artisanaux jusqu'au 30 mai 2026. Une occasion unique de découvrir notre collection de colliers, bracelets et boucles d'oreilles faits main.", 'date_publication' => '2026-05-10', 'type' => 'promotion'],
        (object) ['id' => 2, 'titre' => 'Festival des Artisans à Bamako', 'contenu' => 'Retrouvez-nous au Festival des Artisans de Bamako du 15 au 20 juin 2026. Venez découvrir nos nouveaux produits et rencontrer nos artisans. Stand numéro 42, zone artisanale.', 'date_publication' => '2026-05-08', 'type' => 'event'],
        (object) ['id' => 3, 'titre' => 'Nouvelle Collection de Tissus Bogolan', 'contenu' => 'Nous sommes fiers de vous présenter notre nouvelle collection de tissus bogolan, teints avec des teintures naturelles. Des motifs traditionnels revisités pour un style contemporain.', 'date_publication' => '2026-05-12', 'type' => 'news'],
    ]);
    $items = isset($annonces) && $annonces->count() ? $annonces : $fallbackAnnouncements;
@endphp

<section>
    <div class="container am-container">
        <div class="am-announcement-list">
            @foreach($items as $annonce)
                @php
                    $type = $annonce->type ?? match (true) {
                        str_contains(strtolower($annonce->titre), 'promotion') => 'promotion',
                        str_contains(strtolower($annonce->titre), 'festival') || str_contains(strtolower($annonce->titre), 'événement') => 'event',
                        default => 'news',
                    };
                    $label = ['promotion' => 'Promotion', 'event' => 'Événement', 'news' => 'Actualité'][$type] ?? 'Actualité';
                    $date = $annonce->date_publication ?? $annonce->created_at ?? now();
                @endphp
                <article class="am-announcement-card {{ $type }}">
                    <div class="am-announcement-icon">
                        @if($type === 'promotion')
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.5 13.5 13.5 20.5a2 2 0 0 1-2.8 0L3 12.8V3h9.8l7.7 7.7a2 2 0 0 1 0 2.8Z"/><path d="M7.5 7.5h.01"/></svg>
                        @elseif($type === 'event')
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 2v4M16 2v4M3 10h18M5 5h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/></svg>
                        @else
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h14a2 2 0 0 1 2 2v14H6a2 2 0 0 1-2-2V4Z"/><path d="M8 8h8M8 12h8M8 16h5"/></svg>
                        @endif
                    </div>
                    <div>
                        <div class="am-announcement-meta">
                            <span class="am-announcement-type">{{ $label }}</span>
                            <span class="am-announcement-date">{{ \Carbon\Carbon::parse($date)->translatedFormat('j F Y') }}</span>
                        </div>
                        <h2>{{ $annonce->titre }}</h2>
                        <p>{{ $annonce->contenu }}</p>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <a class="fw-bold text-danger" href="{{ route('annonces.show', $annonce->id) }}">Voir plus -></a>
                            @auth
                                @if(Auth::user()->hasRole('admin') && $annonce instanceof \App\Models\Annonce)
                                    <a class="btn btn-sm btn-outline-dark" href="{{ route('admin.annonces.edit', $annonce) }}">Modifier</a>
                                    <form method="POST" action="{{ route('admin.annonces.destroy', $annonce) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        @if(isset($annonces) && method_exists($annonces, 'links'))
            <div class="pb-5">{{ $annonces->links() }}</div>
        @endif
    </div>
</section>
@endsection
