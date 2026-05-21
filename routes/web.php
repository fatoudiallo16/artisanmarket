<?php

use App\Http\Controllers\AnnonceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\WelcomeController::class, 'index'])->name('welcome');
Auth::routes();     
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('annonces', AnnonceController::class)->only(['index', 'show'])->names('annonces');
Route::resource('produits', App\Http\Controllers\ProduitController::class)
    ->only(['index', 'show'])
    ->names('produits');

Route::middleware(['auth', 'role:vendeur'])->group(function () {
    Route::patch('ma-boutique', [App\Http\Controllers\VendeurController::class, 'updateBoutique'])
        ->name('vendeur.boutique.update');
    Route::resource('produits', App\Http\Controllers\ProduitController::class)
        ->except(['index', 'show'])
        ->names('produits');
});

Route::middleware('auth')->group(function () {
    Route::middleware('role:client')->group(function () {
        Route::post('devenir-vendeur', [App\Http\Controllers\VendeurController::class, 'requestAccess'])
            ->name('vendeur.request');
        Route::get('panier', [App\Http\Controllers\PanierController::class, 'index'])->name('panier.index');
        Route::post('panier', [App\Http\Controllers\PanierController::class, 'store'])->name('panier.store');
        Route::patch('panier/{produit}', [App\Http\Controllers\PanierController::class, 'update'])->name('panier.update');
        Route::delete('panier/{produit}', [App\Http\Controllers\PanierController::class, 'destroy'])->name('panier.destroy');
        Route::delete('panier', [App\Http\Controllers\PanierController::class, 'clear'])->name('panier.clear');
        Route::post('panier/checkout', [App\Http\Controllers\PanierController::class, 'checkout'])->name('panier.checkout');
        Route::post('paiements/{paiement}/pay', [App\Http\Controllers\PaiementController::class, 'pay'])
            ->name('paiements.pay');
        Route::get('paiements/{paiement}/facture', [App\Http\Controllers\PaiementController::class, 'invoice'])
            ->name('paiements.invoice');
        Route::resource('paiements', App\Http\Controllers\PaiementController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('paiements');
        Route::resource('commandes', App\Http\Controllers\CommandeController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('commandes');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('statistics', [App\Http\Controllers\AdminController::class, 'statistics'])->name('statistics');
        Route::get('settings', [App\Http\Controllers\AdminController::class, 'settings'])->name('settings');
        Route::resource('users', App\Http\Controllers\UserController::class)
            ->only(['index']);
        Route::resource('roles', App\Http\Controllers\RoleController::class)
            ->except(['create', 'edit']);
        Route::resource('categories', App\Http\Controllers\CategorieController::class)
            ->except(['create', 'edit']);
        Route::resource('vendeurs', App\Http\Controllers\VendeurController::class)
            ->only(['index', 'show', 'update', 'destroy']);
        Route::resource('produits', App\Http\Controllers\ProduitController::class)->except(['index', 'show']);
        Route::resource('annonces', AnnonceController::class)->except(['index', 'show']);
        Route::resource('paiements', App\Http\Controllers\PaiementController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);
        Route::resource('commandes', App\Http\Controllers\CommandeController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);
     });
});

