@php($items = $produits ?? collect())
@php($gridClass = $gridClass ?? '')
@php
    use App\Support\ProduitVisual;
@endphp

@if($items->isEmpty())
    <div class="am-empty-state">
        <div class="am-empty-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M6 6h15l-1.7 8.5a2 2 0 0 1-2 1.5H9a2 2 0 0 1-2-1.5L5 3H2m7 18h.01M18 21h.01" fill="none" stroke="currentColor" stroke-width="2"/></svg>
        </div>
        <h3>Aucun produit trouvé</h3>
        <p>Essayez une autre catégorie ou modifiez votre recherche.</p>
        <a class="btn am-btn-primary" href="{{ route('produits.index') }}">Voir tout le catalogue</a>
    </div>
@else
    <div class="am-product-grid {{ $gridClass }}">
        @foreach($items as $produit)
            <article class="am-product-card {{ $produit->stock <= 0 ? 'am-product-card--out' : '' }}">
                <a class="am-product-media am-product-media--photo d-block" href="{{ route('produits.show', $produit) }}">
                    <img src="{{ ProduitVisual::imageUrl($produit, $loop->index) }}" alt="{{ $produit->nom }}">
                </a>

                <div class="am-product-body">
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                        <span class="am-badge {{ $produit->stock > 0 ? 'am-badge-new' : 'am-badge-out' }}">
                            {{ $produit->stock > 0 ? 'Disponible' : 'Epuisé' }}
                        </span>
                        <span class="am-rating" aria-label="Note">4.8</span>
                    </div>

                    <h3 class="am-product-title">
                        <a class="text-decoration-none text-dark" href="{{ route('produits.show', $produit) }}">
                            {{ $produit->nom }}
                        </a>
                    </h3>

                    <div class="am-card-meta">
                        <span>{{ $produit->categorie?->nom ?? $produit->categorie?->nom_categorie ?? 'Artisanat' }}</span>
                        <span>{{ $produit->vendeur?->nom_boutique ?? 'Boutique' }}</span>
                    </div>

                    <div class="am-product-footer d-flex justify-content-between gap-3">
                        <span class="am-price">{{ number_format((float) $produit->prix, 0, ',', ' ') }} FCFA</span>
                        <a class="am-product-arrow d-inline-flex align-items-center justify-content-center" href="{{ route('produits.show', $produit) }}" aria-label="Voir {{ $produit->nom }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M5 12h14M13 6l6 6-6 6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>
@endif
