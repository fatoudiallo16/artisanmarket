# 📘 Documentation Technique de A à Z - Projet ArtisanMarket

Ce document offre une description complète, de A à Z, de l'architecture, du code et du fonctionnement de la plateforme **ArtisanMarket**. Il est destiné à tous les développeurs de l'équipe pour comprendre l'intégralité du projet.

---

## 📌 Sommaire
1. [Schéma de Données & Migrations](#-1-schéma-de-données--migrations)
2. [Système d'Authentification & Rôles](#-2-système-dauthentification--rôles)
3. [Modèles de Données (app/Models)](#-3-modèles-de-données-appmodels)
4. [Exceptions & Enums Métier](#-4-exceptions--enums-métier)
5. [Logique Métier : Les Services (app/Services)](#-5-logique-métier--les-services-appservices)
6. [Helpers, Supports & Traits (app/Helpers, app/Support, app/Traits)](#-6-helpers-supports--traits)
7. [Contrôleurs & Routage HTTP (app/Http/Controllers)](#-7-contrôleurs--routage-http)
8. [Sécurité & Autorisations (app/Policies)](#-8-sécurité--autorisations-apppolicies)
9. [Architecture des Vues (resources/views)](#-9-architecture-des-vues)

---

## 🗄️ 1. Schéma de Données & Migrations

La base de données d'ArtisanMarket est structurée pour assurer la flexibilité, la cohérence financière historique et la sécurité des transactions.

### 📋 Description et rôle des migrations

*   **`create_roles_table`** : Définit la table `roles` qui stocke les rôles de base : `client`, `vendeur`, `admin`.
*   **`create_users_table`** : Contient les informations de connexion classiques, liées à la table `roles` via `role_id`.
*   **Profils étendus (`client_profiles`, `vendeur_profiles`, `admin_profiles`)** : Plutôt que de surcharger la table `users` avec des champs spécifiques, les données de profil propres à chaque type d'utilisateur sont isolées dans ces trois tables reliées en relation `1:1` avec `users`.
*   **`create_categories_table`** : Catégories pour classifier les produits (Bijoux, Vannerie, Cuir, Poterie, etc.).
*   **`create_vendeurs_table`** : Gère la boutique d'un vendeur. Elle contient le `user_id` et un statut de validation administrative (`en_attente`, `approuve`, `suspendu`, `rejete`).
*   **`create_produits_table`** : Stocke le catalogue de produits, les prix, la quantité de stock disponible, le statut de mise en vente et l'image associée.
*   **Paniers persistants (`paniers` & `lignepaniers`)** : Permet de conserver le panier d'un client en base de données pour qu'il le retrouve sur n'importe quel appareil.
*   **Commandes historiques (`commandes` & `lignecommandes`)** :
    *   `commandes` : Gère le statut global de la commande (`en_attente`, `en_cours`, `payee`, `annulee`).
    *   `lignecommandes` : Fige la quantité et le prix unitaire du produit **au moment précis de l'achat**. Si le vendeur modifie ultérieurement le prix ou supprime le produit du catalogue, l'historique d'achat du client reste intact.
*   **`create_paiements_table`** : Enregistre le montant payé, le statut du paiement, le mode de paiement (ex: `carte`, `mobile_money`, `virement`), la date et le numéro de facture unique (ex: `AM-INV-2026-000123`).
*   **`create_annonces_table`** : Gère les bannières publicitaires et promotions affichées en page d'accueil.
*   **`create_favoris_table`** : Gère la liste d'envies (wishlist) des clients.
*   **`create_avis_table`** : Permet aux clients d'évaluer et de laisser des commentaires sur les produits.

---

## 🔐 2. Système d'Authentification & Rôles

L'authentification s'appuie sur le système de session standard de Laravel.

*   **Inscription (`/register`)** : L'interface d'inscription ne propose plus de choix de rôle. Tout nouvel utilisateur est inscrit en tant que **client** par défaut.
*   **Création de Vendeurs** : Les vendeurs sont créés à l'aide de **seeders** (base de données) ou promus par l'administrateur en passant le statut de leur boutique à `approuve`.
*   **Middleware de rôle (`role:X`)** : Un middleware personnalisé intercepte les requêtes pour vérifier le rôle de l'utilisateur connecté en le comparant avec la table `roles`. S'il n'a pas les droits requis, une page `403 Unauthorized` est retournée.

---

## 📦 3. Modèles de Données (app/Models)

Chaque modèle représente une table et encapsule ses relations :

1.  **`User`** : Gère le compte. Possède des relations 1:1 vers les profils (`clientProfile`, `vendeurProfile`, `adminProfile`) et une relation vers `role`.
2.  **`Role`** : Contient les rôles possibles.
3.  **`ClientProfile` / `VendeurProfile` / `AdminProfile`** : Contiennent les attributs spécifiques à chaque rôle.
4.  **`Vendeur`** : Représente la boutique et les métadonnées de vente d'un utilisateur vendeur.
5.  **`Produit`** : Gère les informations des produits en vente, relié à `Vendeur` et `Categorie`.
6.  **`Panier` & `Lignepanier`** : Structures du panier persistant.
7.  **`Commande` & `Lignecommande`** : Structures de la commande finale.
8.  **`Paiement`** : Suivi comptable et facturation lié à une commande.
9.  **`Annonce`** : Annonces marketing.
10. **`Avis`** : Évaluations des produits.
11. **`Annonce`** : Modèle gérant les actualités ou promotions.

---

## 🚨 4. Exceptions & Enums Métier

Le projet isole ses états de données et ses cas d'erreur dans des classes dédiées :

### 💎 Enums (`app/Enums`)
*   **`OrderStatus`** : `PENDING` (`en_attente`), `IN_PROGRESS` (`en_cours`), `PAID` (`payee`), `CANCELLED` (`annulee`).
*   **`PaymentStatus`** : `PENDING` (`en_attente`), `PAID` (`paye`), `FAILED` (`echoue`), `REFUNDED` (`rembourse`).
*   **`VendeurStatus`** : `PENDING` (`en_attente`), `APPROVED` (`approuve`), `SUSPENDED` (`suspendu`), `REJECTED` (`rejete`).

### 🛠️ Exceptions personnalisées (`app/Exceptions`)
*   **`EmptyCartException`** : Déclenchée si un client tente de valider une commande avec un panier vide.
*   **`InsufficientStockException`** : Déclenchée lors de la commande si la quantité demandée dépasse le stock réel disponible en magasin. Elle retourne le nom du produit, le stock disponible et la quantité tentée.
*   **`OrderException`** : Regroupe les erreurs globales liées aux commandes (panier introuvable, commande non annulable).
*   **`PaymentException`** : Regroupe les erreurs financières (ex: tentative de remboursement sur une commande non payée).

---

## ⚙️ 5. Logique Métier : Les Services (app/Services)

Pour éviter de surcharger les contrôleurs, toute la logique métier complexe est déportée dans des services injectés :

*   **`OrderService`** :
    *   Gère la transformation du panier en commande.
    *   **Sécurisation contre les Race Conditions** : Il utilise `lockForUpdate()` sur les lignes de produits SQL pour bloquer l'écriture concurrentielle du stock le temps de valider la transaction.
    *   Gère l'annulation d'une commande et restitue le stock aux produits concernés.
*   **`PaymentService`** :
    *   Enregistre les transactions de paiement.
    *   Valide le succès d'un paiement, change le statut de la commande en `payee` et sollicite `InvoiceService` pour éditer la facture.
    *   Traite les remboursements en recréditant le stock de produits.
*   **`InvoiceService`** :
    *   Génère les numéros de facture uniques.
    *   Construit le document de facture au format HTML puis utilise la librairie `Dompdf` pour compiler et générer un fichier PDF stocké dans `storage/app/invoices/`.
*   **`CartService`** :
    *   Gère les ajouts, modifications de quantité et suppressions dans le panier persistant de l'utilisateur.
*   **`VendeurService`** :
    *   Gère l'approbation des profils de boutique et la transition des rôles de l'utilisateur associé.
*   **`AnnonceService`** :
    *   Gère le cycle de vie des annonces promotionnelles.
*   **`ProduitImageService` & `BoutiqueImageService`** :
    *   S'occupent de l'upload sécurisé, du redimensionnement et du stockage des fichiers d'images de produits et de boutiques.

---

## 🛠️ 6. Helpers, Supports & Traits

### 🧰 Helpers (`app/Helpers`)
*   **`OrderHelper`** : Fournit des fonctions d'affichage pour les statuts et le formatage des prix des commandes.
*   **`PaymentHelper`** : Formate les modes de paiement et les statuts financiers.
*   **`StringHelper`** : Fonctions utilitaires pour le formatage de chaînes de caractères.

### 🎨 Support (`app/Support`)
*   **`ProduitVisual`** : Permet d'associer automatiquement des thèmes visuels (icônes de catégorie, jeux de couleurs CSS et images de remplacement (fallback images) par défaut) à des produits selon la catégorie à laquelle ils appartiennent.

### 🧬 Trait (`app/Traits`)
*   **`HasRoleAndProfile`** : Contrat de trait déclarant la vérification de rôle et la synchronisation de profils.

---

## 🛤️ 7. Contrôleurs & Routage HTTP

Les contrôleurs font la passerelle entre les requêtes HTTP, les Services et les Vues.

### 🌐 Vues Publiques (Accessibles à tous)
*   **`WelcomeController`** : Gère la page d'accueil publique (mise en avant des produits populaires, catégories et annonces).
*   **`ProduitController` (Public)** : Affiche le catalogue général de recherche et la fiche détaillée d'un produit.
*   **`BoutiqueController` (Public)** : Affiche la vitrine publique d'une boutique vendeur.

### 👤 Espace Client (Authentifié - Rôle `client`)
*   **`ClientDashboardController`** : Affiche les statistiques du client (nombre de commandes, total dépensé, panier).
*   **`PanierController`** : Gère l'affichage de la page panier et le processus de validation (Checkout).
*   **`CommandeController` (Client)** : Affiche l'historique des commandes d'un client et lui permet d'annuler une commande en attente.
*   **`PaiementController` (Client)** : Permet au client de payer sa commande et de télécharger sa facture PDF.
*   **`FavorisController`** : Permet au client d'ajouter/retirer des produits de sa liste de favoris.

### 🏪 Espace Vendeur (Authentifié - Rôle `vendeur`)
*   **`VendeurDashboardController`** : Statistiques de la boutique (revenus cumulés, ventes réalisées, produits populaires).
*   **`ProduitController` (Vendeur)** : Permet au vendeur de créer, modifier et supprimer ses propres produits.

### 🛡️ Espace Administrateur (Authentifié - Rôle `admin`)
*   **`AdminDashboardController`** : Tableau de bord de supervision de toute la plateforme (utilisateurs, vendeurs, commissions).
*   **`UserController`** : Liste et gestion des comptes utilisateurs.
*   **`VendeurController` (Admin)** : Modération des vendeurs (activation, suspension ou rejet de boutique).
*   **`CommandeController` (Admin)** : Index complet des commandes de la plateforme, avec la capacité de forcer un statut ou supprimer une commande.
*   **`RoleController`** : Configuration administrative des rôles.

---

## 🛡️ 8. Sécurité & Autorisations (app/Policies)

La sécurité de la plateforme est renforcée par des **Policies** Laravel. Elles empêchent le piratage d'URL (ID spoofing) :

*   **`CommandePolicy`** :
    *   `view` : Un client ne peut voir que ses propres commandes. L'administrateur peut voir toutes les commandes.
    *   `delete` : Seul le propriétaire de la commande peut l'annuler (et uniquement si elle est encore en attente ou en cours).
*   **`PaiementPolicy`** :
    *   `view` / `pay` : Seul le client ayant initié la commande rattachée au paiement peut y accéder ou exécuter l'action de règlement.
*   **`ProduitPolicy`** :
    *   `update` / `delete` : Un vendeur ne peut modifier ou supprimer que les produits appartenant à sa propre boutique.

---

## 🎨 9. Architecture des Vues (resources/views)

Les interfaces du site sont découpées et structurées de manière modulaire :

```
views/
├── layouts/
│   ├── app.blade.php        # Layout public & client
│   └── admin.blade.php      # Layout d'administration avec barre latérale
├── auth/                    # Inscription, connexion, mot de passe oublié
├── public/                  # Pages visibles par les visiteurs anonymes
│   ├── welcome.blade.php
│   ├── produits/            # Catalogue et fiches produits
│   └── boutiques/           # Vitrines des boutiques vendeurs
├── client/                  # Espace privé du client
│   ├── dashboard/           # Tableau de bord client
│   ├── commandes/           # Liste et détails des commandes client
│   └── profil/              # Formulaire de modification de profil client
├── vendeur/                 # Espace de gestion du vendeur
│   ├── dashboard/           # Ventes et chiffres de la boutique
│   └── produits/            # Formulaires de gestion de son stock
├── admin/                   # Console d'administration
│   ├── dashboards/          # Chiffres globaux d'ArtisanMarket
│   ├── commandes/           # Modération globale des commandes
│   ├── vendeurs/            # Approbation des boutiques
│   └── categories/          # Gestion des catégories du catalogue
└── pdf/
    └── invoice.blade.php    # Modèle HTML de la facture compilée en PDF par Dompdf
```
