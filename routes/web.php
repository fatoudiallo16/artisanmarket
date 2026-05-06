<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
        });
Auth::routes();     
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('produits', App\Http\Controllers\ProduitController::class)
    ->only(['index', 'show'])
    ->names('produits');

Route::middleware(['auth', 'role:vendeur'])->group(function () {
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
        Route::resource('paiements', App\Http\Controllers\PaiementController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('paiements');
        Route::resource('commandes', App\Http\Controllers\CommandeController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('commandes');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', App\Http\Controllers\UserController::class)
            ->only(['index']);
        Route::resource('vendeurs', App\Http\Controllers\VendeurController::class)
            ->only(['index', 'show', 'update', 'destroy']);
        Route::resource('produits', App\Http\Controllers\ProduitController::class)->except(['index', 'show']);
        Route::resource('paiements', App\Http\Controllers\PaiementController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);
        Route::resource('commandes', App\Http\Controllers\CommandeController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);
     });
});


