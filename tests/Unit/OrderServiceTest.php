<?php

namespace Tests\Unit;

use App\Models\Categorie;
use App\Models\Commande;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\Role;
use App\Models\User;
use App\Models\Vendeur;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    private OrderService $orderService;
    private CartService $cartService;
    private User $user;
    private Produit $produit;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderService = new OrderService();
        $this->cartService = new CartService();

        // Create Roles
        Role::firstOrCreate(['nom_role' => 'client']);
        Role::firstOrCreate(['nom_role' => 'vendeur']);

        // Create client user
        $this->user = User::factory()->create([
            'role_id' => Role::where('nom_role', 'client')->first()->id,
        ]);

        // Create seller user and vendeur
        $seller = User::factory()->create([
            'role_id' => Role::where('nom_role', 'vendeur')->first()->id,
        ]);
        $vendeur = Vendeur::factory()->create([
            'user_id' => $seller->id,
            'id_utilisateur' => $seller->id,
        ]);

        // Create Category
        $categorie = Categorie::factory()->create();

        // Create Product
        $this->produit = Produit::factory()->create([
            'vendeur_id' => $vendeur->id,
            'categorie_id' => $categorie->id,
            'prix' => 1000,
            'stock' => 5,
        ]);
    }

    public function test_create_order_from_cart_success(): void
    {
        $this->actingAs($this->user);

        // Add to cart
        $this->cartService->addToCart($this->produit->id, 2);

        // Verify initial stock
        $this->assertEquals(5, $this->produit->fresh()->stock);

        // Create order
        $commande = $this->orderService->createOrderFromCart($this->user->id);

        $this->assertNotNull($commande);
        $this->assertEquals('en_attente', $commande->statut);
        $this->assertEquals($this->user->id, $commande->user_id);

        // Verify stock decremented
        $this->assertEquals(3, $this->produit->fresh()->stock);

        // Verify cart cleared
        $this->assertEquals(0, $this->cartService->getCartCount());

        // Verify payment record created
        $paiement = Paiement::where('commande_id', $commande->id)->first();
        $this->assertNotNull($paiement);
        $this->assertEquals(2000, $paiement->montant);
        $this->assertEquals('en_attente', $paiement->statut);
    }

    public function test_create_order_from_cart_fails_on_insufficient_stock(): void
    {
        $this->actingAs($this->user);

        // Add to cart
        $this->cartService->addToCart($this->produit->id, 4);

        // Modify product stock behind the scenes (e.g. another user bought it)
        $this->produit->update(['stock' => 2]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Stock insuffisant");

        $this->orderService->createOrderFromCart($this->user->id);
    }

    public function test_cancel_order_restores_stock(): void
    {
        $this->actingAs($this->user);

        // Add to cart and checkout
        $this->cartService->addToCart($this->produit->id, 2);
        $commande = $this->orderService->createOrderFromCart($this->user->id);

        // Stock should be 3 now
        $this->assertEquals(3, $this->produit->fresh()->stock);

        // Cancel order
        $this->orderService->cancelOrder($commande);

        // Check order status
        $this->assertEquals('annulee', $commande->fresh()->statut);

        // Stock should be restored to 5
        $this->assertEquals(5, $this->produit->fresh()->stock);

        // Associated payment should be echoue
        $paiement = Paiement::where('commande_id', $commande->id)->first();
        $this->assertEquals('echoue', $paiement->statut);
    }

    public function test_cancel_paid_order_fails(): void
    {
        $this->actingAs($this->user);

        // Add to cart and checkout
        $this->cartService->addToCart($this->produit->id, 2);
        $commande = $this->orderService->createOrderFromCart($this->user->id);

        // Simulate payment completion
        $commande->update(['statut' => 'payee']);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Impossible d'annuler une commande payée");

        $this->orderService->cancelOrder($commande);
    }
}
