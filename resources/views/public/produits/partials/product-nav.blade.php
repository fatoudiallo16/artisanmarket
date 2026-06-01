@if($previous || $next)
<nav class="am-product-nav" aria-label="Navigation entre produits">
    @if($previous)
        <a class="am-product-nav-btn am-product-nav-btn--prev" href="{{ route('produits.show', $previous) }}">
            <span class="am-product-nav-label">Produit précédent</span>
            <span class="am-product-nav-title">{{ \Illuminate\Support\Str::limit($previous->nom, 42) }}</span>
        </a>
    @else
        <span class="am-product-nav-btn am-product-nav-btn--prev am-product-nav-btn--disabled" aria-disabled="true">
            <span class="am-product-nav-label">Produit précédent</span>
            <span class="am-product-nav-title">—</span>
        </span>
    @endif

    <a class="am-product-nav-catalog" href="{{ route('produits.index') }}">Catalogue</a>

    @if($next)
        <a class="am-product-nav-btn am-product-nav-btn--next" href="{{ route('produits.show', $next) }}">
            <span class="am-product-nav-label">Produit suivant</span>
            <span class="am-product-nav-title">{{ \Illuminate\Support\Str::limit($next->nom, 42) }}</span>
        </a>
    @else
        <span class="am-product-nav-btn am-product-nav-btn--next am-product-nav-btn--disabled" aria-disabled="true">
            <span class="am-product-nav-label">Produit suivant</span>
            <span class="am-product-nav-title">—</span>
        </span>
    @endif
</nav>
@endif
