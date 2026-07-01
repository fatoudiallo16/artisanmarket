<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\BoutiqueController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\ClientProfileController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VendeurController;
use App\Http\Controllers\VendeurDashboardController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('produits', [ProduitController::class, 'index'])->name('produits.index');
Route::get('produits/categorie/{categorie}', [ProduitController::class, 'byCategorie'])->name('produits.categorie');
Route::get('produits/{produit}', [ProduitController::class, 'show'])->name('produits.show');

Route::get('boutiques/{vendeur}', [BoutiqueController::class, 'show'])->name('boutiques.show');

Route::get('annonces', [AnnonceController::class, 'index'])->name('annonces.index');
Route::get('annonces/{annonce}', [AnnonceController::class, 'show'])->name('annonces.show');

/*
|--------------------------------------------------------------------------
| Routes authentifiées
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('me/profile', [ProfileController::class, 'show'])->name('me.profile');
    Route::get('profil', [ClientProfileController::class, 'show'])->name('client.profile');
    Route::delete('profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('panier', [PanierController::class, 'index'])->name('panier.index');
    Route::post('panier', [PanierController::class, 'store'])->name('panier.store')->middleware('throttle:10,1');
    Route::patch('panier/{produit}', [PanierController::class, 'update'])->name('panier.update');
    Route::delete('panier/{produit}', [PanierController::class, 'destroy'])->name('panier.destroy');
    Route::delete('panier', [PanierController::class, 'clear'])->name('panier.clear');
    Route::post('panier/checkout', [PanierController::class, 'checkout'])->name('panier.checkout')->middleware('throttle:6,1');

    Route::post('favoris/toggle/{produit}', [FavorisController::class, 'toggle'])->name('favoris.toggle');
    Route::get('favoris', [FavorisController::class, 'index'])->name('favoris.index');
    Route::post('produits/{produit}/avis', [AvisController::class, 'store'])->name('produits.avis.store');

    /*
    |--------------------------------------------------------------------------
    | Client
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:client')->group(function () {
        Route::get('client/dashboard', [ClientDashboardController::class, 'index'])->name('client.dashboard');

        Route::post('devenir-vendeur', [VendeurController::class, 'requestAccess'])->name('vendeur.request')->middleware('throttle:6,1');

        Route::resource('commandes', CommandeController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('commandes');

        Route::resource('paiements', PaiementController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('paiements');

        Route::post('paiements/{paiement}/pay', [PaiementController::class, 'pay'])->name('paiements.pay')->middleware('throttle:6,1');
        Route::get('paiements/{paiement}/invoice', [PaiementController::class, 'invoice'])->name('paiements.invoice');
    });

    /*
    |--------------------------------------------------------------------------
    | Vendeur
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:vendeur')->prefix('vendeur')->name('vendeur.')->group(function () {
        Route::get('dashboard', [VendeurDashboardController::class, 'index'])->name('dashboard');

        Route::resource('produits', ProduitController::class);
    });

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', CategorieController::class);

        Route::resource('users', UserController::class)->only(['index']);

        Route::resource('vendeurs', VendeurController::class)
            ->only(['index', 'show', 'update', 'destroy']);

        Route::resource('produits', ProduitController::class)->except(['index', 'show']);

        Route::resource('commandes', CommandeController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);

        Route::resource('paiements', PaiementController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);

        Route::resource('annonces', AnnonceController::class)->except(['index', 'show']);

        Route::resource('roles', RoleController::class);
    });
});
