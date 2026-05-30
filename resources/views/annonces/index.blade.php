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

<section>
    <div class="container am-container">
        @if($annonces->isEmpty())
            <div class="am-panel text-center py-5">
                <p class="text-muted mb-0">Aucune annonce publiée pour le moment.</p>
            </div>
        @else
        <div class="am-announcement-list">
            @foreach($annonces as $annonce)
                @php
                    $type = match (true) {
                        str_contains(strtolower($annonce->titre), 'promotion') => 'promotion',
                        str_contains(strtolower($annonce->titre), 'festival') || str_contains(strtolower($annonce->titre), 'événement') => 'event',
                        default => 'news',
                    };
                    $label = ['promotion' => 'Promotion', 'event' => 'Événement', 'news' => 'Actualité'][$type] ?? 'Actualité';
                    $date = $annonce->date_publication ?? $annonce->created_at;
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
                            <a class="fw-bold text-danger" href="{{ route('annonces.show', $annonce) }}">Voir plus -></a>
                            @auth
                                @if(Auth::user()->hasRole('admin'))
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

        <div class="pb-5">{{ $annonces->links() }}</div>
        @endif
    </div>
</section>
@endsection
