@extends('layouts.app')

@section('title', 'Catalogue - Artisan Market')

@section('content')
<section class="am-catalog-hero">
    <div class="container am-container">
        <p class="am-eyebrow">Artisanat du Mali</p>
        <h1 class="am-page-title">Catalogue</h1>
        <p class="am-page-lead">Plus de {{ $produits->total() }} créations artisanales — bijoux, tissus, poterie et bien plus.</p>
    </div>
</section>

<section class="am-catalog-main pb-5">
    <div class="container am-container">
        <form class="am-toolbar am-toolbar--catalog" method="GET" action="{{ route('produits.index') }}">
            @if(request('categorie'))
                <input type="hidden" name="categorie" value="{{ request('categorie') }}">
            @endif
            <label class="am-search" aria-label="Rechercher un produit">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m21 21-4.3-4.3m1.3-5.2a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0Z"/></svg>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher un produit, une matière…">
            </label>
            <select class="am-select px-4" name="sort" onchange="this.form.submit()" aria-label="Trier les produits">
                <option value="vedette" @selected(request('sort', 'vedette') === 'vedette')>En vedette</option>
                <option value="prix_asc" @selected(request('sort') === 'prix_asc')>Prix croissant</option>
                <option value="prix_desc" @selected(request('sort') === 'prix_desc')>Prix décroissant</option>
                <option value="nouveautes" @selected(request('sort') === 'nouveautes')>Nouveautés</option>
            </select>
            <button type="submit" class="btn am-btn-primary d-none d-md-inline-flex">Rechercher</button>
        </form>

        @if(request('q') || request('categorie'))
            <div class="am-active-filters">
                <span class="am-active-filters-label">Filtres actifs :</span>
                @if(request('q'))
                    <a class="am-filter-chip" href="{{ route('produits.index', request()->except('q', 'page')) }}">
                        « {{ request('q') }} » <span aria-hidden="true">×</span>
                    </a>
                @endif
                @if(request('categorie'))
                    <a class="am-filter-chip" href="{{ route('produits.index', request()->except('categorie', 'page')) }}">
                        {{ ucfirst(request('categorie')) }} <span aria-hidden="true">×</span>
                    </a>
                @endif
                <a class="am-filter-clear" href="{{ route('produits.index') }}">Tout effacer</a>
            </div>
        @endif

        <div class="am-products-layout">
            <aside class="am-filter-card">
                <h2 class="am-filter-title">Catégories</h2>
                <a class="am-filter-link {{ request('categorie') ? '' : 'active' }}" href="{{ route('produits.index', request()->except('categorie', 'page')) }}">
                    <span>Tous les produits</span>
                    <span class="am-filter-count">{{ $produits->total() }}</span>
                </a>
                @foreach($categories as $categorie)
                    @php($categoryName = $categorie->{$categoryColumn} ?? $categorie->nom ?? $categorie->nom_categorie)
                    <a class="am-filter-link {{ request('categorie') === $categoryName ? 'active' : '' }}" href="{{ route('produits.index', array_merge(request()->except('page'), ['categorie' => $categoryName])) }}">
                        <span>{{ ucfirst($categoryName) }}</span>
                        <span class="am-filter-count">{{ $categorie->produits_count }}</span>
                    </a>
                @endforeach
            </aside>

            <div class="am-catalog-results">
                <div class="am-results-bar">
                    <p><strong>{{ $produits->total() }}</strong> produit{{ $produits->total() > 1 ? 's' : '' }} trouvé{{ $produits->total() > 1 ? 's' : '' }}</p>
                    <span class="am-results-pages">Page {{ $produits->currentPage() }} / {{ $produits->lastPage() }}</span>
                </div>
                @include('produits.partials.grid', ['produits' => $produits])
                @if($produits->hasPages())
                    <div class="am-pagination-wrap">
                        {{ $produits->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
