@extends('layouts.app')

@section('title', 'ArtisanMarket')

@section('content')

    {{-- HERO --}}
    @include('composants.sections.hero')

    {{-- SERVICES --}}
    @include('composants.sections.services')

    {{-- CATEGORIES --}}
    @include('composants.sections.categories')


    {{-- PRODUITS VEDETTES --}}
    @include('composants.sections.produits-vedettes')
@endsection