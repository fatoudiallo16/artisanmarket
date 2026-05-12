<!-- resources/views/annonces/index.blade.php -->
@extends('layouts.app')

@section('content')
<h1>📢 Annonces</h1>
@foreach($annonces as $annonce)
  <div class="card">
    <h2>{{ $annonce->titre }}</h2>
    <p>{{ Str::limit($annonce->contenu, 100) }}</p>
    @if($annonce->image)
      <img src="{{ asset('storage/'.$annonce->image) }}" alt="Annonce image">
    @endif
    <a href="{{ route('annonces.show', $annonce->id) }}">Voir plus</a>
  </div>
@endforeach
{{ $annonces->links() }}
@endsection
