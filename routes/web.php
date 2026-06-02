<?php

use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\VendeurController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ============ PUBLIC ROUTES ============

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Authentification routes
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Public product and announcement routes
Route::resource('produits', ProduitController::class)
    ->only(['index', 'show'])
    ->names('produits');

Route::resource('annonces', AnnonceController::class)
    ->only(['index', 'show'])
    ->names('annonces');

Route::get('boutiques/{vendeur}', [VendeurController::class, 'boutique'])
    ->name('boutiques.show');

Route::view('favoris', 'public.favoris.index')->name('favoris.index');

// ============ AUTHENTICATED ROUTES ============

Route::middleware('auth')->group(function () {
    
    // -------- CLIENT ROUTES --------
    Route::middleware('role:client')->group(function () {
        // Dashboard
        Route::get('/client/dashboard', function () {
            return view('client.dashboard.dashboard');
        })->name('client.dashboard');

        // Vendeur request
        Route::post('devenir-vendeur', [VendeurController::class, 'requestAccess'])
            ->name('vendeur.request');

        // Cart routes
        Route::get('panier', [PanierController::class, 'index'])->name('panier.index');
        Route::post('panier', [PanierController::class, 'store'])->name('panier.store');
        Route::patch('panier/{produit}', [PanierController::class, 'update'])->name('panier.update');
        Route::delete('panier/{produit}', [PanierController::class, 'destroy'])->name('panier.destroy');
        Route::delete('panier', [PanierController::class, 'clear'])->name('panier.clear');
        Route::post('panier/checkout', [PanierController::class, 'checkout'])->name('panier.checkout');

        // Orders routes
        Route::resource('commandes', CommandeController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('commandes');

        // Payment routes
        Route::resource('paiements', PaiementController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy'])
            ->names('paiements');
        Route::post('paiements/{paiement}/pay', [PaiementController::class, 'pay'])
            ->name('paiements.pay');
        Route::get('paiements/{paiement}/facture', [PaiementController::class, 'invoice'])
            ->name('paiements.invoice');
    });

    // -------- VENDOR ROUTES --------
    Route::middleware('role:vendeur')->group(function () {
        // Dashboard
        Route::get('/vendeur/dashboard', function () {
            return view('vendeur.dashboard.index');
        })->name('vendeur.dashboard');

        // Update boutique
        Route::patch('ma-boutique', [VendeurController::class, 'updateBoutique'])
            ->name('vendeur.boutique.update');

        // Product management (CRUD)
        Route::resource('vendeur/produits', ProduitController::class)
            ->except(['index', 'show'])
            ->names('vendeur.produits');
    });

    // -------- ADMIN ROUTES --------
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('statistics', [AdminController::class, 'statistics'])->name('statistics');
        Route::get('settings', [AdminController::class, 'settings'])->name('settings');

        // Users management
        Route::resource('users', UserController::class)->only(['index']);

        // Roles management
        Route::resource('roles', RoleController::class)->except(['create', 'edit']);

        // Categories management
        Route::resource('categories', CategorieController::class)
            ->except(['create', 'edit'])
            ->parameters(['categories' => 'categorie']);

        // Vendors management
        Route::resource('vendeurs', VendeurController::class)
            ->only(['index', 'show', 'update', 'destroy']);

        // Products management
        Route::resource('produits', ProduitController::class)
            ->except(['index', 'show']);

        // Announcements management
        Route::resource('annonces', AnnonceController::class)
            ->except(['index', 'show']);

        // Payments management
        Route::resource('paiements', PaiementController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);

        // Orders management
        Route::resource('commandes', CommandeController::class)
            ->only(['index', 'show', 'store', 'update', 'destroy']);
    });
});
