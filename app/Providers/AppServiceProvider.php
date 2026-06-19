<?php

namespace App\Providers;

use App\Models\Commande;
use App\Models\Paiement;
use App\Models\Produit;
use App\Policies\CommandePolicy;
use App\Policies\PaiementPolicy;
use App\Policies\ProduitPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Commande::class, CommandePolicy::class);
        Gate::policy(Paiement::class, PaiementPolicy::class);
        Gate::policy(Produit::class, ProduitPolicy::class);

        view()->composer('composants.navigation.NAVBAR', function ($view) {
            if (auth()->check()) {
                $cartService = app(\App\Services\CartService::class);
                try {
                    $view->with('cartCount', $cartService->getCartCount());
                } catch (\Exception $e) {
                    $view->with('cartCount', 0);
                }
            } else {
                $view->with('cartCount', 0);
            }
        });
    }
}
