@extends('layouts.app')

@section('title', 'Catalogue - Artisan Market')

@section('content')
<section class="am-page-head">
    <div class="container am-container">
        <h1 class="am-page-title">Catalogue</h1>
        <p class="am-page-lead">Découvrez tous nos produits artisanaux</p>

        <form class="am-toolbar" method="GET" action="{{ route('produits.index') }}">
            <label class="am-search" aria-label="Rechercher un produit">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m21 21-4.3-4.3m1.3-5.2a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0Z"/></svg>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Rechercher un produit...">
            </label>
            <select class="am-select px-4" name="sort" onchange="this.form.submit()">
                <option value="vedette" @selected(request('sort', 'vedette') === 'vedette')>En vedette</option>
                <option value="prix_asc" @selected(request('sort') === 'prix_asc')>Prix croissant</option>
                <option value="prix_desc" @selected(request('sort') === 'prix_desc')>Prix décroissant</option>
                <option value="nouveautes" @selected(request('sort') === 'nouveautes')>Nouveautés</option>
            </select>
        </form>
    </div>
</section>

<section class="pb-5">
    <div class="container am-container">
        <div class="am-products-layout">
            <aside class="am-filter-card">
                <h2 class="h3 fw-bold mb-4">Catégories</h2>
                <a class="am-filter-link {{ request('categorie') ? '' : 'active' }}" href="{{ route('produits.index', request()->except('categorie', 'page')) }}">
                    <span>Tous les produits</span>
                    <span>{{ $produits->total() }}</span>
                </a>
                @forelse($categories as $categorie)
                    @php($categoryName = $categorie->{$categoryColumn} ?? $categorie->nom ?? $categorie->nom_categorie)
                    <a class="am-filter-link {{ request('categorie') === $categoryName ? 'active' : '' }}" href="{{ route('produits.index', array_merge(request()->except('page'), ['categorie' => $categoryName])) }}">
                        <span>{{ ucfirst($categoryName) }}</span>
                        <span>{{ $categorie->produits_count }}</span>
                    </a>
                @empty
                    <div class="am-filter-link active"><span>Bijoux</span><span>3</span></div>
                    <div class="am-filter-link"><span>Tissus</span><span>3</span></div>
                    <div class="am-filter-link"><span>Poterie</span><span>3</span></div>
                @endforelse
            </aside>

            <div>
                <p class="fs-5 text-muted mb-4">{{ $produits->total() }} produits trouvés</p>
                @include('produits.partials.grid', ['produits' => $produits])
                <div class="mt-4">
                    {{ $produits->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
