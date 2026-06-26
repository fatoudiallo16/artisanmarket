<?php

namespace Tests\Feature;

use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Lignecommande;
use App\Models\Produit;
use App\Models\Role;
use App\Models\User;
use App\Models\Vendeur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditFunctionalRequirementsTest extends TestCase
{
    use RefreshDatabase;

    private Role $clientRole;
    private Role $vendeurRole;
    private Role $adminRole;

    protected function setUp(): void
    {
        parent::setUp();

        // Create standard roles
        $this->clientRole = Role::firstOrCreate(['nom_role' => 'client']);
        $this->vendeurRole = Role::firstOrCreate(['nom_role' => 'vendeur']);
        $this->adminRole = Role::firstOrCreate(['nom_role' => 'admin']);
    }

    /**
     * F06: User Account Deletion
     */
    public function test_user_can_delete_their_own_account(): void
    {
        $user = User::factory()->create(['role_id' => $this->clientRole->id]);
        $user->syncProfileByRole();

        $response = $this->actingAs($user)
            ->delete(route('profile.destroy'));

        $response->assertRedirect(route('welcome'));
        $response->assertSessionHas('success');
        $this->assertModelMissing($user);
        $this->assertGuest();
    }

    /**
     * F06: Seller Dashboard Statistics and Performance Tracking
     */
    public function test_seller_dashboard_shows_correct_sales_metrics(): void
    {
        // 1. Setup seller and products
        $sellerUser = User::factory()->create(['role_id' => $this->vendeurRole->id]);
        $sellerUser->syncProfileByRole();

        $vendeur = Vendeur::create([
            'user_id' => $sellerUser->id,
            'id_utilisateur' => $sellerUser->id,
            'name' => $sellerUser->name,
            'nom_boutique' => 'Artisan d\'Afrique',
            'statut' => 'approuve',
        ]);

        $category = Categorie::firstOrCreate(['name' => 'Poterie']);

        $product1 = Produit::create([
            'nom' => 'Vase en argile',
            'prix' => 15000,
            'stock' => 10,
            'vendeur_id' => $sellerUser->id,
            'categorie_id' => $category->id,
            'status' => 'approved',
        ]);

        $product2 = Produit::create([
            'nom' => 'Assiette tressée',
            'prix' => 5000,
            'stock' => 20,
            'vendeur_id' => $sellerUser->id,
            'categorie_id' => $category->id,
            'status' => 'approved',
        ]);

        // 2. Setup customer and orders
        $customerUser = User::factory()->create(['role_id' => $this->clientRole->id]);

        // Order 1: Paid (statut = payee) -> should count in sales stats
        $orderPaid = Commande::create([
            'user_id' => $customerUser->id,
            'statut' => 'payee',
        ]);

        Lignecommande::create([
            'commande_id' => $orderPaid->id,
            'produit_id' => $product1->id,
            'quantite' => 2,
            'prix_unitaire' => 15000,
        ]);

        Lignecommande::create([
            'commande_id' => $orderPaid->id,
            'produit_id' => $product2->id,
            'quantite' => 1,
            'prix_unitaire' => 5000,
        ]);

        // Order 2: Pending (statut = en_attente) -> should NOT count in sales stats
        $orderPending = Commande::create([
            'user_id' => $customerUser->id,
            'statut' => 'en_attente',
        ]);

        Lignecommande::create([
            'commande_id' => $orderPending->id,
            'produit_id' => $product2->id,
            'quantite' => 3,
            'prix_unitaire' => 5000,
        ]);

        // 3. Request Seller Dashboard
        $response = $this->actingAs($sellerUser)->get(route('vendeur.dashboard'));

        $response->assertStatus(200);

        // Assert metrics passed to view
        $response->assertViewHas('salesCount', 1); // 1 paid order
        $response->assertViewHas('productsSold', 3); // 2 of product1 + 1 of product2
        $response->assertViewHas('revenue', 35000.0); // (2 * 15000) + (1 * 5000) = 35000
        
        // Assert recent sales contains the two order lines of the paid order and one of pending order
        $recentSales = $response->viewData('recentSales');
        $this->assertCount(3, $recentSales);
    }

    /**
     * F07: Admin Order Deletion
     */
    public function test_admin_can_delete_orders_but_client_cannot(): void
    {
        $adminUser = User::factory()->create(['role_id' => $this->adminRole->id]);
        $clientUser = User::factory()->create(['role_id' => $this->clientRole->id]);

        $order = Commande::create([
            'user_id' => $clientUser->id,
            'statut' => 'en_attente',
        ]);

        // 1. Client attempts to delete order using admin route -> should be forbidden (403)
        $response = $this->actingAs($clientUser)
            ->delete(route('admin.commandes.destroy', $order));
        $response->assertStatus(403);
        $this->assertModelExists($order);

        // 2. Admin attempts to delete order using admin route -> should succeed
        $response = $this->actingAs($adminUser)
            ->delete(route('admin.commandes.destroy', $order));

        $response->assertRedirect(route('admin.commandes.index'));
        $this->assertModelMissing($order);
    }
}
