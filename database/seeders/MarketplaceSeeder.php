<?php

namespace Database\Seeders;

use App\Models\Annonce;
use App\Models\Categorie;
use App\Models\Produit;
use App\Models\Role;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        $categories = collect([
            'bijoux' => Categorie::firstOrCreate(['name' => 'bijoux']),
            'tissus' => Categorie::firstOrCreate(['name' => 'tissus']),
            'poterie' => Categorie::firstOrCreate(['name' => 'poterie']),
        ]);

        $clientRole = Role::where('nom_role', 'client')->first();
        $vendeurRole = Role::where('nom_role', 'vendeur')->first();
        $adminRole = Role::where('nom_role', 'admin')->first();

        if ($clientRole) {
            $client = User::updateOrCreate(
                ['email' => 'client@artisanmarket.test'],
                [
                    'name' => 'Awa Diallo',
                    'password' => 'Client@12345',
                    'role_id' => $clientRole->id,
                ]
            );
            $client->load('role');
            $client->syncProfileByRole();
        }

        $vendeursData = [
            [
                'email' => 'aminata@artisanmarket.test',
                'name' => 'Aminata Traoré',
                'nom_boutique' => 'Atelier Aminata',
                'produits' => [
                    ['nom' => 'Collier en Perles Dorées', 'description' => 'Bijou artisanal soigneusement assemblé.', 'prix' => 15000, 'stock' => 12, 'cat' => 'bijoux'],
                    ['nom' => 'Bracelet Bogolan', 'description' => 'Bracelet tissé main, motifs traditionnels.', 'prix' => 8500, 'stock' => 20, 'cat' => 'bijoux'],
                ],
            ],
            [
                'email' => 'moussa@artisanmarket.test',
                'name' => 'Moussa Konaté',
                'nom_boutique' => 'Bronze & Terre',
                'produits' => [
                    ['nom' => 'Boucles d’Oreilles en Bronze', 'description' => 'Finition bronze et éclat bleu profond.', 'prix' => 12000, 'stock' => 8, 'cat' => 'bijoux'],
                    ['nom' => 'Vase en Terre Cuite', 'description' => 'Poterie artisanale, pièce unique.', 'prix' => 18000, 'stock' => 5, 'cat' => 'poterie'],
                ],
            ],
            [
                'email' => 'fatou@artisanmarket.test',
                'name' => 'Fatou Diarra',
                'nom_boutique' => 'Tissus Fatou',
                'produits' => [
                    ['nom' => 'Tissu Bogolan Traditionnel', 'description' => 'Motifs maliens teints naturellement.', 'prix' => 22000, 'stock' => 15, 'cat' => 'tissus'],
                    ['nom' => 'Écharpe Bazin Riche', 'description' => 'Tissu premium pour cérémonies.', 'prix' => 35000, 'stock' => 10, 'cat' => 'tissus'],
                ],
            ],
        ];

        if ($vendeurRole) {
            foreach ($vendeursData as $data) {
                $user = User::updateOrCreate(
                    ['email' => $data['email']],
                    [
                        'name' => $data['name'],
                        'password' => 'Vendeur@12345',
                        'role_id' => $vendeurRole->id,
                    ]
                );
                $user->load('role');
                $user->syncProfileByRole();

                $vendeur = Vendeur::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'statut' => 'approuve',
                        'name' => $data['name'],
                        'nom_boutique' => $data['nom_boutique'],
                    ]
                );

                foreach ($data['produits'] as $p) {
                    Produit::updateOrCreate(
                        [
                            'nom' => $p['nom'],
                            'vendeur_id' => $vendeur->id,
                        ],
                        [
                            'description' => $p['description'],
                            'prix' => $p['prix'],
                            'stock' => $p['stock'],
                            'categorie_id' => $categories[$p['cat']]->id,
                        ]
                    );
                }
            }
        }

        if ($adminRole) {
            $admin = User::where('email', 'admin@artisanmarket.test')->first();
            if ($admin) {
                Annonce::updateOrCreate(
                    ['titre' => 'Nouvelle collection de tissus Bogolan'],
                    [
                        'contenu' => 'Découvrez notre nouvelle collection de tissus bogolan, teints avec des teintures naturelles.',
                        'date_publication' => now()->toDateString(),
                        'user_id' => $admin->id,
                    ]
                );
                Annonce::updateOrCreate(
                    ['titre' => 'Promotion Spéciale Bijoux - 20% de Réduction'],
                    [
                        'contenu' => "Profitez de 20% de réduction sur une sélection de bijoux artisanaux jusqu'à fin du mois.",
                        'date_publication' => now()->subDays(2)->toDateString(),
                        'user_id' => $admin->id,
                    ]
                );
                Annonce::updateOrCreate(
                    ['titre' => 'Festival des Artisans à Bamako'],
                    [
                        'contenu' => 'Retrouvez nos vendeurs au Festival des Artisans de Bamako. Stand zone artisanale.',
                        'date_publication' => now()->subDays(5)->toDateString(),
                        'user_id' => $admin->id,
                    ]
                );
            }
        }

        // Seed orders, favorites, and reviews for Awa Diallo (client)
        if (isset($client)) {
            // Get some products
            $products = Produit::take(3)->get();

            if ($products->isNotEmpty()) {
                // 1. Seed a paid order containing the first product
                $p1 = $products[0];
                $commande = \App\Models\Commande::firstOrCreate(
                    [
                        'user_id' => $client->id,
                        'statut' => 'payee',
                    ]
                );

                \App\Models\Lignecommande::firstOrCreate(
                    [
                        'commande_id' => $commande->id,
                        'produit_id' => $p1->id,
                    ],
                    [
                        'quantite' => 1,
                        'prix_unitaire' => $p1->prix,
                    ]
                );

                \App\Models\Paiement::firstOrCreate(
                    [
                        'commande_id' => $commande->id,
                    ],
                    [
                        'montant' => $p1->prix,
                        'mode_paiement' => 'carte',
                        'statut' => 'paye',
                        'date_paiement' => now(),
                    ]
                );

                // 2. Seed a review for the first product
                \App\Models\Avis::firstOrCreate(
                    [
                        'user_id' => $client->id,
                        'produit_id' => $p1->id,
                    ],
                    [
                        'note' => 5,
                        'commentaire' => 'Ce produit est d’une qualité artisanale exceptionnelle ! Je le recommande vivement.',
                    ]
                );

                // 3. Seed another review from a different user (e.g. fatou@artisanmarket.test user)
                $otherUser = User::where('email', 'fatou@artisanmarket.test')->first();
                if ($otherUser && isset($products[1])) {
                    $p2 = $products[1];
                    
                    // Create paid order for other user
                    $commandeOther = \App\Models\Commande::firstOrCreate(
                        [
                            'user_id' => $otherUser->id,
                            'statut' => 'payee',
                        ]
                    );
                    \App\Models\Lignecommande::firstOrCreate(
                        [
                            'commande_id' => $commandeOther->id,
                            'produit_id' => $p2->id,
                        ],
                        [
                            'quantite' => 2,
                            'prix_unitaire' => $p2->prix,
                        ]
                    );
                    \App\Models\Paiement::firstOrCreate(
                        [
                            'commande_id' => $commandeOther->id,
                        ],
                        [
                            'montant' => $p2->prix * 2,
                            'mode_paiement' => 'momo',
                            'statut' => 'paye',
                            'date_paiement' => now(),
                        ]
                    );

                    \App\Models\Avis::firstOrCreate(
                        [
                            'user_id' => $otherUser->id,
                            'produit_id' => $p2->id,
                        ],
                        [
                            'note' => 4,
                            'commentaire' => 'Très satisfait du travail de tissage. Quelques retards de livraison mais excellent produit.',
                        ]
                    );
                }

                // 4. Seed a favorite for the second product for the main client
                if (isset($products[1])) {
                    $client->favoris()->syncWithoutDetaching([$products[1]->id]);
                }
            }
        }
    }
}
