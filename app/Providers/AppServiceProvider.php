<?php

namespace App\Providers;

use App\Models\Annonce;
use App\Models\Commande;
use App\Models\Paiement;
use App\Models\Produit;
use App\Policies\AnnoncePolicy;
use App\Policies\CommandePolicy;
use App\Policies\PaiementPolicy;
use App\Policies\ProduitPolicy;
use App\Services\CartService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrapFive();

        Gate::policy(Annonce::class, AnnoncePolicy::class);
        Gate::policy(Commande::class, CommandePolicy::class);
        Gate::policy(Paiement::class, PaiementPolicy::class);
        Gate::policy(Produit::class, ProduitPolicy::class);

        View::composer('layouts.app', function ($view): void {
            $cartCount = 0;
            $user = Auth::user();

            if ($user && $user->hasRole('client')) {
                $cartCount = app(CartService::class)->getCartCount($user->id);
            }

            $view->with('cartCount', $cartCount);
        });
    }
}
