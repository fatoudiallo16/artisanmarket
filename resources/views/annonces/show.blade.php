@extends('layouts.app')

@section('title', $annonce->titre . ' - Artisan Market')

@section('content')
<section class="am-page-head">
    <div class="container am-container">
        <a class="fw-bold text-danger" href="{{ route('annonces.index') }}"><- Retour aux annonces</a>
        <h1 class="am-page-title mt-4">{{ $annonce->titre }}</h1>
        <p class="am-page-lead">{{ \Carbon\Carbon::parse($annonce->date_publication ?? $annonce->created_at)->translatedFormat('j F Y') }}</p>
        @auth
            @if(Auth::user()->hasRole('admin'))
                <div class="d-flex gap-2">
                    <a class="btn btn-outline-dark" href="{{ route('admin.annonces.edit', $annonce) }}">Modifier</a>
                    <form method="POST" action="{{ route('admin.annonces.destroy', $annonce) }}">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger" type="submit">Supprimer</button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</section>
<section class="pb-5">
    <div class="container am-container">
        <article class="am-announcement-card news">
            @if($annonce->image)
                <div></div>
                <img class="rounded w-100 mb-4" src="{{ asset('storage/'.$annonce->image) }}" alt="{{ $annonce->titre }}">
            @endif
            <div class="am-announcement-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h14a2 2 0 0 1 2 2v14H6a2 2 0 0 1-2-2V4Z"/><path d="M8 8h8M8 12h8M8 16h5"/></svg>
            </div>
            <p class="mb-0">{{ $annonce->contenu }}</p>
        </article>
    </div>
</section>
@endsection
