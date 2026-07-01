<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Produit;
use App\Models\Role;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProduitArtisanalMaliSeeder extends Seeder
{
    public function run(): void
    {
        $categoryNames = [
            'bijoux', 'tissus', 'poterie', 'cuir',
        ];

        $categories = collect($categoryNames)->mapWithKeys(
            fn (string $name) => [$name => Categorie::firstOrCreate(['name' => $name])]
        );

        $vendeurRole = Role::where('nom_role', 'vendeur')->first();
        if (!$vendeurRole) {
            return;
        }

        $vendeurs = $this->ensureVendeurs($vendeurRole);
        $catalogue = $this->catalogue();

        $vendeurIds = $vendeurs->pluck('id')->values()->all();
        $vendeurCount = count($vendeurIds);
        $index = 0;

        foreach ($catalogue as $item) {
            $vendeurId = $vendeurIds[$index % $vendeurCount];
            $index++;

            Produit::updateOrCreate(
                [
                    'nom' => $item['nom'],
                    'vendeur_id' => $vendeurId,
                ],
                [
                    'description' => $item['description'],
                    'prix' => $item['prix'],
                    'stock' => $item['stock'],
                    'categorie_id' => $categories[$item['cat']]->id,
                ]
            );
        }
    }

    private function ensureVendeurs(Role $vendeurRole): \Illuminate\Support\Collection
    {
        $boutiques = [
            ['email' => 'aminata@artisanmarket.test', 'name' => 'Aminata Traoré', 'boutique' => 'Atelier Aminata — Bijoux'],
            ['email' => 'moussa@artisanmarket.test', 'name' => 'Moussa Konaté', 'boutique' => 'Bronze & Terre — Poterie'],
            ['email' => 'fatou@artisanmarket.test', 'name' => 'Fatou Diarra', 'boutique' => 'Tissus Fatou — Bogolan'],
            ['email' => 'sekou@artisanmarket.test', 'name' => 'Sekou Coulibaly', 'boutique' => 'Bogolan Ségou'],
            ['email' => 'modibo@artisanmarket.test', 'name' => 'Modibo Kanté', 'boutique' => 'Cuir & Peaux Tombouctou'],
        ];

        return collect($boutiques)->map(function (array $data) use ($vendeurRole) {
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

            return Vendeur::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'statut' => 'approuve',
                    'name' => $data['name'],
                    'nom_boutique' => $data['boutique'],
                ]
            );
        });
    }

    /**
     * @return list<array{nom: string, description: string, prix: float, stock: int, cat: string}>
     */
    private function catalogue(): array
    {
        $items = [];

        $bijoux = [
            ['Collier Perles Dogon', 'Collier de perles multicolores inspiré des traditions dogon du pays dogon. Perles de verre et métal forgé à la main.', 18500, 14],
            ['Bracelet Argent Touareg', 'Bracelet en argent gravé de symboles touaregs, réalisé par artisan nomade du nord Mali.', 22000, 9],
            ['Boucles Oreilles Bronze', 'Boucles en bronze coulé, finition patinée bleu nuit. Pièce légère pour usage quotidien.', 12500, 18],
            ['Pendentif Croix Agadez', 'Pendentif croix d\'Agadez en laiton, symbole de protection dans la culture touareg.', 9800, 22],
            ['Bracelet Perles Heishi', 'Bracelet perles heishi en argile polie, teintes ocre et indigo du bogolan.', 7500, 25],
            ['Collier Ambre Sahélien', 'Collier long avec perles style ambre et intercalaires en cuir tressé.', 28000, 7],
            ['Bague Filigrane Bamako', 'Bague filigrane en argent, motifs géométriques inspirés de l\'architecture soudanaise.', 15000, 11],
            ['Bracelet Cuir et Laiton', 'Bracelet mixte cuir tanné végétal et plaques de laiton martelé.', 11000, 16],
            ['Collier Coquillages Niger', 'Collier de cauris et coquillages du fleuve Niger, monté sur fil de coton ciré.', 13500, 13],
            ['Diadème Cérémonial', 'Diadème perles et métal pour mariages traditionnels bambara.', 45000, 4],
            ['Bracelet Bogolan Tissé', 'Bracelet textile bogolan avec fermoir en bois sculpté.', 6500, 20],
            ['Boucles Disque Indigo', 'Boucles plates teintes à l\'indigo de Djenné, monture laiton.', 14000, 15],
        ];

        foreach ($bijoux as [$nom, $desc, $prix, $stock]) {
            $items[] = ['nom' => $nom, 'description' => $desc, 'prix' => $prix, 'stock' => $stock, 'cat' => 'bijoux'];
        }

        $tissus = [
            ['Bogolan Authentique 2m', 'Tissu bogolan 2 mètres, teintures végétales (écorce, feuilles, boue ferreuse). Motifs géométriques Ségou.', 35000, 12],
            ['Bogolan Proverbes 3m', 'Grand bogolan 3 m avec motifs proverbes bambara brodés à la main.', 52000, 6],
            ['Bazin Riche Damassé', 'Bazin riche damassé, teint main à Bamako. Idéal pour grand boubou.', 48000, 10],
            ['Bazin Brodé Or', 'Bazin premium broderie or, pièce de cérémonie.', 75000, 5],
            ['Indigo Djenné 2m', 'Tissu indigo de Djenné, technique ancestral de teinture en cuves.', 42000, 8],
            ['Écharpe Fula Tissée', 'Écharpe coton tissé par artisans peuls, rayures ocre et bordeaux.', 18000, 20],
            ['Pagne Wax Mali', 'Pagne wax aux motifs inspirés de la faune malienne (hippopotame, crocodile).', 15000, 30],
            ['Set Bogolan Coussins', 'Lot de 4 housses coussin bogolan assorties (50×50 cm).', 28000, 14],
            ['Tissu Khassida Brodé', 'Tissu brodé calligraphie khassida pour décoration murale.', 38000, 7],
            ['Bogolan Enfant', 'Bogolan format enfant pour apprentissage culturel (1 m).', 12000, 18],
            ['Étoffe Bazin Simple', 'Bazin teint uni, base pour couture sur mesure.', 32000, 15],
            ['Châle Indigo Léger', 'Châle indigo léger, porté cérémonie ou quotidien.', 24000, 11],
            ['Tissu Bogolan Noir', 'Bogolan fond noir, motifs blancs traditionnels funéraires et initiatiques.', 40000, 9],
            ['Set Table Bogolan', 'Nappe et 6 sets de table bogolan coordonnés.', 45000, 6],
            ['Moussor Tissé Main', 'Moussor traditionnel tissé coton et soie sauvage, foulard cérémonie.', 55000, 5],
        ];

        foreach ($tissus as [$nom, $desc, $prix, $stock]) {
            $items[] = ['nom' => $nom, 'description' => $desc, 'prix' => $prix, 'stock' => $stock, 'cat' => 'tissus'];
        }

        $poterie = [
            ['Vase Terre Ségou', 'Vase en terre cuite de Ségou, forme amphore, décor incisé.', 22000, 10],
            ['Canari Eau Traditionnel', 'Canari à eau selon forme traditionnelle dogon, étanchéité naturelle.', 18500, 8],
            ['Bol Cérémonial', 'Bol cérémonial laqué ocre, usage offrandes ou décoration.', 15000, 14],
            ['Pot à Mil', 'Grand pot de conservation du mil, poterie du Mandé.', 28000, 5],
            ['Théière Terre Cuite', 'Théière terre cuite compatible feu direct, style touareg.', 12000, 16],
            ['Set Bols Assortis', 'Set de 6 bols tailles différentes, finition lisse.', 24000, 12],
            ['Statuette Femme', 'Statuette terre cuite femme portant canari, art populaire.', 32000, 6],
            ['Plateau Service', 'Plateau creux pour service collectif, diamètre 45 cm.', 26000, 7],
            ['Jarre Fermentation', 'Jarre pour fermentation boisson de mil (dolo).', 35000, 4],
            ['Poterie Miniature', 'Lot 12 miniatures pour collection ou cadeau touristique.', 8000, 25],
            ['Urne Décorative', 'Urne haute décoration motifs spirale, Ségou.', 30000, 5],
            ['Mortier Pilón', 'Mortier et pilon terre cuite pour épices.', 14000, 11],
        ];

        foreach ($poterie as [$nom, $desc, $prix, $stock]) {
            $items[] = ['nom' => $nom, 'description' => $desc, 'prix' => $prix, 'stock' => $stock, 'cat' => 'poterie'];
        }

        $bois = [
            ['Masque Dogon', 'Masque rituel dogon sculpté en bois de ceiba, pièce murale authentique.', 85000, 3],
            ['Statuette Ancestre', 'Statuette ancêtre bois patiné, région de Bandiagara.', 65000, 4],
            ['Porte Sculptée Mini', 'Réplique miniature porte granary dogon sculptée.', 42000, 7],
            ['Cuillère Cérémonielle', 'Grande cuillère sculptée bois d\'ébène, usage cérémonie harvest.', 38000, 6],
            ['Tabouret Bambara', 'Tabouret bas sculpté trois pieds, motifs fertilité.', 55000, 5],
            ['Sceptre Griot', 'Sceptre bois sculpté tête de calao, symbole griot.', 48000, 4],
            ['Boîte à Bijoux Bois', 'Boîte sculptée compartiments, bois de rose africain.', 22000, 12],
            ['Flûte Peule', 'Flûte traversière peule sculptée et perforée à la main.', 15000, 10],
            ['Pilon Bois Sculpté', 'Pilon cuisine sculpté tête animale, usage quotidien.', 18000, 14],
            ['Masque Miniature', 'Série 3 masques miniatures pour étagère.', 25000, 9],
            ['Chameau Bois Sculpté', 'Sculpture chameau bois d\'acacia, symbole caravane transsaharienne.', 32000, 8],
            ['Pirogue Miniature', 'Pirogue fleuve Niger sculptée, socle bois.', 28000, 7],
        ];

        // Catégorie 'sculpture bois' supprimée

        $cuir = [
            ['Sandales Cuir Touareg', 'Sandales cuir tannage végétal, semelle robuste pour désert.', 28000, 15],
            ['Sacoche Selle', 'Sacoche cuir style selle chameau, broderie traditionnelle.', 45000, 8],
            ['Ceinture Tressée', 'Ceinture cuir tressé main, boucle laiton forgé.', 12000, 20],
            ['Portefeuille Cuir', 'Portefeuille cuir embossé motifs géométriques.', 15000, 18],
            ['Bottes Artisanales', 'Bottes cuir mi-mollet, couture renforcée.', 65000, 6],
            ['Étui Couteau', 'Étui cuir pour couteau traditionnel touareg.', 8500, 22],
            ['Sac Bandoulière', 'Sac bandoulière cuir et bogolan, poche intérieure.', 38000, 10],
            ['Bracelet Cuir Gravé', 'Bracelet cuir large gravé nom ou symbole.', 7500, 25],
        ];

        foreach ($cuir as [$nom, $desc, $prix, $stock]) {
            $items[] = ['nom' => $nom, 'description' => $desc, 'prix' => $prix, 'stock' => $stock, 'cat' => 'cuir'];
        }

        // Catégories supprimées : instruments, maroquinerie, art mural, vannerie, cosmetiques

        return $items;
    }
}
