@props(['produit', 'showExcerpt' => true, 'loopIndex' => null])

@php
    use App\Support\ProduitVisual;

    $theme = ProduitVisual::forProduit($produit);
    $imageUrl = ProduitVisual::imageUrl($produit, $loopIndex);
    $categoryName = $produit->categorie?->nom ?? $produit->categorie?->nom_categorie ?? $theme['label'];
    $vendor = $produit->vendeur->nom_boutique ?? $produit->vendeur->name ?? 'Artisan';
    $inStock = (int) $produit->stock > 0;
    $isNew = $produit->created_at && $produit->created_at->gt(now()->subDays(14));
@endphp

<article class="am-product-card" data-category="{{ $theme['slug'] }}">
    <a href="{{ route('produits.show', $produit) }}" class="am-product-media-link">
        <div class="am-product-media am-product-media--photo">
            @if($isNew)
                <span class="am-badge am-badge-new">Nouveau</span>
            @endif
            @if(!$inStock)
                <span class="am-badge am-badge-out">Rupture</span>
            @endif
            <span class="am-product-category-pill">{{ ucfirst($categoryName) }}</span>
            <img src="{{ $imageUrl }}" alt="{{ $produit->nom }}" loading="lazy">
            <span class="am-product-hover-cta">Voir le produit</span>
        </div>
    </a>
    <div class="am-product-body">
        <div class="am-product-vendor">
            <span class="am-vendor-dot" aria-hidden="true"></span>
            {{ $vendor }}
        </div>
        <h3 class="am-product-title">
            <a href="{{ route('produits.show', $produit) }}">{{ $produit->nom }}</a>
        </h3>
        @if($showExcerpt && filled($produit->description))
            <p class="am-product-excerpt">{{ Str::limit($produit->description, 88) }}</p>
        @endif
        <div class="am-product-footer">
            <div>
                <strong class="am-price">{{ number_format((float) $produit->prix, 0, ',', ' ') }} <small>FCFA</small></strong>
                @if($inStock)
                    <span class="am-stock am-stock-in">{{ $produit->stock }} dispo.</span>
                @else
                    <span class="am-stock am-stock-out">Indisponible</span>
                @endif
            </div>
            <a class="am-product-arrow" href="{{ route('produits.show', $produit) }}" aria-label="Voir {{ $produit->nom }}">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>
    </div>
</article>
