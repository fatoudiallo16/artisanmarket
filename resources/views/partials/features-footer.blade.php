<section class="am-feature-band">
    <div class="container am-container am-feature-grid">
        <div>
            <div class="am-feature-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2 4 6.5v9L12 20l8-4.5v-9L12 2Z"/><path d="m4 6.5 8 4.5 8-4.5M12 11v9"/></svg>
            </div>
            <h3>Produits Authentiques</h3>
            <p>100% fait main par des artisans locaux</p>
        </div>
        <div>
            <div class="am-feature-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 1 0-7.8 7.8l8.8 8.8 8.8-8.8a5.5 5.5 0 0 0 0-7.8Z"/></svg>
            </div>
            <h3>Qualité Garantie</h3>
            <p>Chaque produit est contrôlé avec soin</p>
        </div>
        <div>
            <div class="am-feature-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m3 17 6-6 4 4 8-8"/><path d="M14 7h7v7"/></svg>
            </div>
            <h3>Soutien aux Artisans</h3>
            <p>Votre achat soutient directement les artisans</p>
        </div>
    </div>
</section>

<footer class="am-footer">
    <div class="container am-container">
        <div class="row g-5">
            <div class="col-md-3">
                <h3>Artisan Market</h3>
                <p>Plateforme de vente en ligne de produits artisanaux maliens authentiques.</p>
            </div>
            <div class="col-md-3">
                <h4>Navigation</h4>
                <p><a href="{{ url('/') }}">Accueil</a></p>
                <p><a href="{{ route('produits.index') }}">Catalogue</a></p>
                <p><a href="{{ route('annonces.index') }}">Annonces</a></p>
            </div>
            <div class="col-md-3">
                <h4>Informations</h4>
                <p><a href="#">À propos</a></p>
                <p><a href="#">Contact</a></p>
                <p><a href="#">Confidentialité</a></p>
            </div>
            <div class="col-md-3">
                <h4>Contact</h4>
                <p>Email: contact@artisan-market.com</p>
                <p>Tél: +223 70 00 00 00</p>
                <p>Bamako, Mali</p>
            </div>
        </div>
    </div>
</footer>
