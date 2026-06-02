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
use Illuminate\Support\Facades\Schema;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        $categoryColumn = match (true) {
            Schema::hasColumn('categories', 'name') => 'name',
            Schema::hasColumn('categories', 'nom') => 'nom',
            default => 'nom_categorie',
        };

        $categories = collect([
            'bijoux' => Categorie::firstOrCreate([$categoryColumn => 'bijoux']),
            'tissus' => Categorie::firstOrCreate([$categoryColumn => 'tissus']),
            'poterie' => Categorie::firstOrCreate([$categoryColumn => 'poterie']),
        ]);

        $clientRole = Role::where('nom_role', 'client')->first();
        $vendeurRole = Role::where('nom_role', 'vendeur')->first();
        $adminRole = Role::where('nom_role', 'admin')->first();

        if ($clientRole) {
            $client = User::updateOrCreate(
                ['email' => 'client@artisanmarket.test'],
                [
                    'name' => 'Awa Diallo',
                    'password' => Hash::make('Client@12345'),
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
                        'password' => Hash::make('Vendeur@12345'),
                        'role_id' => $vendeurRole->id,
                    ]
                );
                $user->load('role');
                $user->syncProfileByRole();

                $vendeur = Vendeur::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'id_utilisateur' => $user->id,
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
    }
}
