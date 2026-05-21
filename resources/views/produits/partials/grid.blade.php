@php($items = $produits ?? collect())

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
    <div class="am-product-grid">
        @foreach($items as $produit)
            <x-product-card :produit="$produit" :loop-index="$loop->index" />
        @endforeach
    </div>
@endif
