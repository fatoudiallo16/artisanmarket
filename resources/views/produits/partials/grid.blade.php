@php
    $items = $produits ?? collect();
    $images = [
        asset('assets/img/product/product-1.jpg'),
        asset('assets/img/product/product-2.jpg'),
        asset('assets/img/product/product-3.jpg'),
        asset('assets/img/product/product-4.jpg'),
        asset('assets/img/product/product-5.jpg'),
        asset('assets/img/product/product-6.jpg'),
    ];
    $categoryName = fn ($produit) => $produit->categorie?->nom ?? $produit->categorie?->nom_categorie ?? 'Artisanat';
@endphp

@if($items->isEmpty())
    <div class="am-empty">Aucun produit pour le moment.</div>
@else
<div class="am-product-grid">
    @foreach($items as $produit)
        <article class="am-product-card">
            <a href="{{ route('produits.show', $produit) }}" class="am-product-media">
                @if($produit->created_at && $produit->created_at->gt(now()->subDays(14)))
                    <span class="am-badge">Nouveau</span>
                @endif
                <img src="{{ $images[$loop->index % count($images)] }}" alt="{{ $produit->nom }}">
            </a>
            <div class="am-product-body">
                <a class="am-product-title" href="{{ route('produits.show', $produit) }}">{{ $produit->nom }}</a>
                <p class="am-product-meta">{{ $produit->vendeur->nom_boutique ?? $produit->vendeur->name ?? 'Artisan Market' }}</p>
                <div class="d-flex align-items-center gap-2 mt-3">
                    <span class="text-muted">{{ $produit->stock > 0 ? $produit->stock . ' en stock' : 'Rupture' }}</span>
                </div>
                <div class="d-flex align-items-center justify-content-between gap-3 mt-3">
                    <strong class="am-price">{{ number_format((float) $produit->prix, 0, ',', ' ') }} FCFA</strong>
                    <span class="text-muted">{{ ucfirst($categoryName($produit)) }}</span>
                </div>
            </div>
        </article>
    @endforeach
</div>
@endif
