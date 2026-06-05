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
    }
}
