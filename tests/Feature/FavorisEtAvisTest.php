<?php

namespace Tests\Feature;

use App\Models\Avis;
use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Lignecommande;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\Role;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavorisEtAvisTest extends TestCase
{
    use RefreshDatabase;

    private Role $clientRole;
    private Role $vendeurRole;

    protected function setUp(): void
    {
        parent::setUp();

        $this->clientRole = Role::firstOrCreate(['nom_role' => 'client']);
        $this->vendeurRole = Role::firstOrCreate(['nom_role' => 'vendeur']);
    }

    private function createProduct(): Produit
    {
        $category = Categorie::firstOrCreate(['name' => 'Artisanat', 'slug' => 'artisanat']);
        
        $vendeurUser = User::factory()->create(['role_id' => $this->vendeurRole->id]);
        $vendeurUser->syncProfileByRole();
        
        $vendeur = Vendeur::create([
            'user_id' => $vendeurUser->id,
            'id_utilisateur' => $vendeurUser->id,
            'name' => $vendeurUser->name,
            'nom_boutique' => 'Ma Boutique Test',
            'statut' => 'approuve',
        ]);

        return Produit::create([
            'nom' => 'Produit Test ' . uniqid(),
            'prix' => 10000,
            'stock' => 5,
            'categorie_id' => $category->id,
            'vendeur_id' => $vendeur->id,
        ]);
    }

    /**
     * Test Toggle Favorites
     */
    public function test_user_can_toggle_favorites(): void
    {
        $user = User::factory()->create(['role_id' => $this->clientRole->id]);
        $user->syncProfileByRole();

        $product = $this->createProduct();

        // 1. Add to favorites
        $response = $this->actingAs($user)
            ->post(route('favoris.toggle', $product));

        $response->assertRedirect();
        $this->assertTrue($user->favoris()->where('produit_id', $product->id)->exists());

        // 2. Remove from favorites
        $response = $this->actingAs($user)
            ->post(route('favoris.toggle', $product));

        $response->assertRedirect();
        $this->assertFalse($user->favoris()->where('produit_id', $product->id)->exists());
    }

    /**
     * Test Guest Cannot Toggle Favorites
     */
    public function test_guest_cannot_toggle_favorites(): void
    {
        $product = $this->createProduct();

        $response = $this->post(route('favoris.toggle', $product));
        $response->assertRedirect(route('login'));
    }

    /**
     * Test Review Purchased Product
     */
    public function test_user_can_review_purchased_product(): void
    {
        $user = User::factory()->create(['role_id' => $this->clientRole->id]);
        $user->syncProfileByRole();

        $product = $this->createProduct();

        // Create paid order for this product
        $order = Commande::create([
            'user_id' => $user->id,
            'statut' => 'payee',
        ]);
        Lignecommande::create([
            'commande_id' => $order->id,
            'produit_id' => $product->id,
            'quantite' => 1,
            'prix_unitaire' => $product->prix,
        ]);
        Paiement::create([
            'commande_id' => $order->id,
            'montant' => $product->prix,
            'mode_paiement' => 'momo',
            'statut' => 'paye',
            'date_paiement' => now(),
        ]);

        // Submit review
        $response = $this->actingAs($user)
            ->post(route('produits.avis.store', $product), [
                'note' => 5,
                'commentaire' => 'Excellent produit, bien fini.',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('avis', [
            'user_id' => $user->id,
            'produit_id' => $product->id,
            'note' => 5,
            'commentaire' => 'Excellent produit, bien fini.',
        ]);

        $this->assertEquals(5.0, $product->averageRating());
        $this->assertEquals(1, $product->ratingsCount());
    }

    /**
     * Test User Cannot Review Unpurchased Product
     */
    public function test_user_cannot_review_unpurchased_product(): void
    {
        $user = User::factory()->create(['role_id' => $this->clientRole->id]);
        $user->syncProfileByRole();

        $product = $this->createProduct();

        // Submit review without purchase -> 403 Forbidden
        $response = $this->actingAs($user)
            ->post(route('produits.avis.store', $product), [
                'note' => 4,
                'commentaire' => 'Tentative d’avis sans achat.',
            ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('avis', [
            'user_id' => $user->id,
            'produit_id' => $product->id,
        ]);
    }

    /**
     * Test User Cannot Review Product Multiple Times
     */
    public function test_user_cannot_review_product_multiple_times(): void
    {
        $user = User::factory()->create(['role_id' => $this->clientRole->id]);
        $user->syncProfileByRole();

        $product = $this->createProduct();

        // Create paid order
        $order = Commande::create([
            'user_id' => $user->id,
            'statut' => 'payee',
        ]);
        Lignecommande::create([
            'commande_id' => $order->id,
            'produit_id' => $product->id,
            'quantite' => 1,
            'prix_unitaire' => $product->prix,
        ]);

        // Insert first review in DB
        Avis::create([
            'user_id' => $user->id,
            'produit_id' => $product->id,
            'note' => 5,
            'commentaire' => 'Premier avis.',
        ]);

        // Try submitting second review
        $response = $this->actingAs($user)
            ->post(route('produits.avis.store', $product), [
                'note' => 3,
                'commentaire' => 'Deuxième avis.',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        
        $this->assertDatabaseHas('avis', [
            'user_id' => $user->id,
            'produit_id' => $product->id,
            'note' => 5,
        ]);
        $this->assertDatabaseMissing('avis', [
            'user_id' => $user->id,
            'produit_id' => $product->id,
            'note' => 3,
        ]);
    }
}
