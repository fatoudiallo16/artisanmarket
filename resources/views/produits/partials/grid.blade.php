@php
    $fallbackProducts = collect([
        (object) ['id' => 1, 'nom' => 'Collier en Perles Dorées', 'prix' => 15000, 'description' => 'Bijou artisanal soigneusement assemblé.', 'vendeur' => (object) ['name' => 'Aminata Traoré'], 'categorie' => (object) ['nom' => 'bijoux']],
        (object) ['id' => 2, 'nom' => 'Boucles d’Oreilles en Bronze', 'prix' => 12000, 'description' => 'Finition bronze et éclat bleu profond.', 'vendeur' => (object) ['name' => 'Moussa Konaté'], 'categorie' => (object) ['nom' => 'bijoux']],
        (object) ['id' => 3, 'nom' => 'Tissu Bogolan Traditionnel', 'prix' => 22000, 'description' => 'Motifs maliens teints naturellement.', 'vendeur' => (object) ['name' => 'Fatou Diarra'], 'categorie' => (object) ['nom' => 'tissus']],
    ]);
    $allowFallback = $allowFallback ?? true;
    $items = isset($produits) && $produits->count() ? $produits : ($allowFallback ? $fallbackProducts : collect());
    $images = [
        asset('assets/img/product/product-1.jpg'),
        asset('assets/img/product/product-2.jpg'),
        asset('assets/img/product/product-3.jpg'),
        asset('assets/img/product/product-4.jpg'),
        asset('assets/img/product/product-5.jpg'),
        asset('assets/img/product/product-6.jpg'),
    ];
@endphp

@if($items->isEmpty())
    <div class="am-empty">Aucun produit pour le moment.</div>
@else
<div class="am-product-grid">
    @foreach($items as $index => $produit)
        <article class="am-product-card">
            <a href="{{ Route::has('produits.show') && isset($produit->id) ? route('produits.show', $produit->id) : '#' }}" class="am-product-media">
                <span class="am-badge">Nouveau</span>
                <img src="{{ $images[$loop->index % count($images)] }}" alt="{{ $produit->nom }}">
            </a>
            <div class="am-product-body">
                <a class="am-product-title" href="{{ Route::has('produits.show') && isset($produit->id) ? route('produits.show', $produit->id) : '#' }}">{{ $produit->nom }}</a>
                <p class="am-product-meta">{{ $produit->vendeur->name ?? $produit->vendeur->nom_boutique ?? 'Artisan Market' }}</p>
                <div class="d-flex align-items-center gap-2 mt-3 am-rating">
                    <span>★</span> {{ number_format(4.7 + (($loop->index % 3) / 10), 1) }}
                    <small class="text-muted">({{ 24 + ($loop->index * 7) }})</small>
                </div>
                <div class="d-flex align-items-center justify-content-between gap-3 mt-3">
                    <strong class="am-price">{{ number_format((float) $produit->prix, 0, ',', ' ') }} FCFA</strong>
                    <span class="text-muted">{{ ucfirst($produit->categorie->nom ?? 'Artisanat') }}</span>
                </div>
            </div>
        </article>
    @endforeach
</div>
@endif
