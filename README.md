# Artisan Market

**Artisan Market** est une plateforme web de commerce en ligne dédiée aux **produits artisanaux**. Elle met en relation des **clients**, des **vendeurs** (artisans) et un **administrateur** dans un même écosystème : catalogue, panier, commandes, paiements et gestion des annonces.

Projet développé dans le cadre d’un défi base de données / application web (Laravel), avec une interface et une architecture orientée rôles.

---

## Fonctionnalités principales

### Visiteurs et clients
- Parcourir le **catalogue** de produits (recherche, tri, filtres par catégorie)
- Consulter les **annonces** de la marketplace
- S’inscrire / se connecter (authentification Laravel UI)
- Ajouter des produits au **panier**, modifier les quantités, vider le panier
- **Passer commande** et suivre l’historique des commandes
- Gérer les **paiements** associés aux commandes
- Demander l’accès **vendeur** depuis l’espace client (création d’une boutique)

### Vendeurs
- Gérer sa **boutique** (profil vendeur)
- Créer, modifier et supprimer ses **produits**
- Accéder à son tableau de bord vendeur

### Administrateur
- Tableau de bord global (statistiques, vue d’ensemble)
- Gestion des **utilisateurs**, **rôles** et **catégories**
- Modération des **vendeurs** et validation des demandes
- Gestion des **produits**, **annonces**, **commandes** et **paiements**

---

## Stack technique

| Composant | Technologie |
|-----------|-------------|
| Backend | PHP 8.3+, **Laravel 13** |
| Base de données | **MySQL** |
| Authentification | Laravel UI (`Auth::routes`) |
| Frontend | **Blade**, Bootstrap 5, CSS personnalisé (`public/assets/css/artisan-market.css`) |
| Architecture métier | Services (`CartService`, `OrderService`, `PaymentService`) |

---

## Modèle de données (aperçu)

- **users** — comptes avec rôle (`client`, `vendeur`, `admin`)
- **produits** / **categories** — catalogue artisanal
- **paniers** / **lignepaniers** — panier par utilisateur
- **commandes** / **lignecommandes** — commandes validées
- **paiements** — suivi du règlement
- **vendeurs** / profils (**client_profiles**, **vendeur_profiles**, **admin_profiles**)
- **annonces** — communication / promotion sur la plateforme

---

## Structure du projet

```
artisanmarket/
├── app/
│   ├── Http/Controllers/   # Contrôleurs (Panier, Commande, Produit, Admin…)
│   ├── Http/Middleware/    # Contrôle d’accès par rôle (RoleMiddleware)
│   ├── Models/             # Modèles Eloquent
│   ├── Services/           # Logique panier, commandes, paiements
│   └── Policies/           # Autorisations (commandes, etc.)
├── database/
│   ├── migrations/
│   └── seeders/            # Rôles, catégories, compte admin par défaut
├── resources/views/        # Vues Blade (catalogue, panier, dashboards…)
├── routes/web.php          # Routes publiques et protégées par rôle
└── public/                 # Point d’entrée et assets statiques
```

---

## Prérequis

- PHP **8.3** ou supérieur
- Composer
- MySQL (ou MariaDB)
- Extension PHP : `pdo_mysql`, `mbstring`, `openssl`, etc.
- Node.js et npm (optionnel, pour les assets front si compilation Vite)

---

## Installation

```bash
# Cloner le dépôt et entrer dans le dossier
cd artisanmarket

# Dépendances PHP
composer install

# Configuration environnement
cp .env.example .env   # ou copier manuellement votre fichier .env
php artisan key:generate

# Configurer dans .env :
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=artisanmarket
# DB_USERNAME=...
# DB_PASSWORD=...

# Base de données (obligatoire — tout le catalogue vient de la DB)
php artisan migrate
php artisan db:seed

# Réinitialiser et repeupler la DB (109 produits maliens inclus)
php artisan migrate:fresh --seed

# Ajouter uniquement le catalogue étendu (sans tout réinitialiser)
php artisan db:seed --class=ProduitArtisanalMaliSeeder

# Lien symbolique pour les images vendeur (produits & boutiques)
php artisan storage:link

# Lancer le serveur de développement
php artisan serve
# Exemple : http://127.0.0.1:8000
```

Les vendeurs peuvent téléverser une **photo par produit** et un **logo de boutique**. Fichiers stockés dans `storage/app/public/produits/vendeur_{id}/` et `storage/app/public/boutiques/user_{id}/`. Chaque produit reste lié à un `vendeur_id` ; la vitrine publique est accessible via `/boutiques/{id}`.

Les seeders `MarketplaceSeeder` et `ProduitArtisanalMaliSeeder` créent **109+ produits artisanaux maliens** (nom, description, prix FCFA, stock), **13 vendeurs**, **11 catégories** et des annonces en base.

| Rôle | E-mail | Mot de passe |
|------|--------|--------------|
| Admin | `admin@artisanmarket.test` | `Admin@12345` |
| Client | `client@artisanmarket.test` | `Client@12345` |
| Vendeur | `aminata@artisanmarket.test` | `Vendeur@12345` |

Pour un port personnalisé :

```bash
php artisan serve --port=8004
```

---

## Compte administrateur (après seed)

| Champ | Valeur |
|-------|--------|
| E-mail | `admin@artisanmarket.test` |
| Mot de passe | `Admin@12345` |

Les rôles **client** et **vendeur** sont créés par le seeder ; inscrivez-vous via la page d’inscription pour obtenir un compte client.

---

## Rôles et routes clés

| Rôle | Exemples de routes |
|------|-------------------|
| Public | `/`, `/produits`, `/annonces`, `/login`, `/register` |
| Client | `/home`, `/panier`, `/commandes`, `/paiements`, `POST /devenir-vendeur` |
| Vendeur | CRUD `/produits`, `PATCH /ma-boutique` |
| Admin | `/admin`, gestion users, rôles, catégories, vendeurs, commandes |

Le middleware `role:client`, `role:vendeur` ou `role:admin` protège les sections sensibles.

---

## Flux métier typique (client)

1. Consulter le **catalogue** et ouvrir la fiche d’un produit
2. **Ajouter au panier**
3. Ouvrir **Mon panier** (`/panier`) — ajuster quantités ou retirer des articles
4. **Passer la commande** → redirection vers les commandes
5. **Payer** — le paiement est enregistré en base (`paiements`) avec numéro de facture et PDF téléchargeable

---

## Tests

```bash
php artisan test
```

---

## Déploiement sur Vercel

Ce projet Laravel utilise le runtime **vercel-php** (PHP 8.3). Ne pas utiliser `outputDirectory` seul : l’application doit passer par `server.php`.

### Fichiers de déploiement

| Fichier | Rôle |
|---------|------|
| `vercel.json` | Runtime PHP, routes vers `server.php`, variables pour `/tmp` |
| `server.php` | Sert les assets de `public/` puis délègue à Laravel |
| `.vercelignore` | Exclut `.env`, caches locaux, etc. |

### Variables d’environnement (dashboard Vercel)

À configurer dans **Project → Settings → Environment Variables** (ne pas commiter) :

| Variable | Exemple / note |
|----------|----------------|
| `APP_KEY` | `php artisan key:generate --show` |
| `APP_URL` | URL de production (`https://votre-projet.vercel.app`) |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` | Hôte MySQL distant (PlanetScale, Railway, etc.) |
| `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` | Credentials du service |
| `DB_PORT` | `3306` |

Optionnel si la base est prête au déploiement : ajouter dans `composer.json` → script `vercel` la ligne `@php artisan migrate --force`.

### Build

Vercel exécute `composer install` puis le script `vercel` défini dans `composer.json` (`npm run build`, lien `storage`).

### Limitations serverless

- Pas de `php artisan serve` : tout passe par des fonctions PHP.
- Sessions : `cookie` par défaut sur Vercel (`vercel.json`) ; possible `database` si MySQL distant + table `sessions`.
- Fichiers uploadés : stockage éphémère ; prévoir S3 ou équivalent en production.
- Base locale `127.0.0.1` ne fonctionne pas : utiliser une base MySQL hébergée.

---

## Sécurité

- Ne commitez **jamais** le fichier `.env` (clés, mots de passe base de données).
- Changez le mot de passe administrateur par défaut en production.
- Les actions sensibles (commandes, paiements) passent par des **policies** Laravel.

---

## Licence

Projet à usage **éducatif** / démonstration. Adapter la licence selon les consignes de votre établissement ou organisation.

---

## Auteurs

Projet **Artisan Market** — marketplace artisanale Laravel.
Pour toute évolution (API, tests, déploiement), documenter les changements dans ce README.
