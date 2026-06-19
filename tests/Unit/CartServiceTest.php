<?php

namespace Tests\Unit;

use App\Models\Categorie;
use App\Models\Produit;
use App\Models\Role;
use App\Models\User;
use App\Models\Vendeur;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    private CartService $cartService;
    private User $user;
    private Produit $produit;

    protected function setUp(): void
    {
        parent::setUp();

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

    public function test_get_or_create_cart(): void
    {
        $this->actingAs($this->user);

        $cart = $this->cartService->getOrCreateCart();

        $this->assertNotNull($cart);
        $this->assertEquals($this->user->id, $cart->user_id);

        // Fetching again should return the same cart
        $cart2 = $this->cartService->getOrCreateCart();
        $this->assertEquals($cart->id, $cart2->id);
    }

    public function test_add_to_cart(): void
    {
        $this->actingAs($this->user);

        $item = $this->cartService->addToCart($this->produit->id, 2);

        $this->assertNotNull($item);
        $this->assertEquals(2, $item->quantite);
        $this->assertEquals($this->produit->prix, $item->prix_unitaire);

        $items = $this->cartService->getCartItems();
        $this->assertCount(1, $items);
        $this->assertEquals(2, $items->first()->quantite);
    }

    public function test_add_to_cart_fails_on_insufficient_stock(): void
    {
        $this->actingAs($this->user);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Stock insuffisant");

        // Limit is 5, trying to add 6
        $this->cartService->addToCart($this->produit->id, 6);
    }

    public function test_update_quantity(): void
    {
        $this->actingAs($this->user);

        $this->cartService->addToCart($this->produit->id, 2);
        
        $item = $this->cartService->updateQuantity($this->produit->id, 4);

        $this->assertNotNull($item);
        $this->assertEquals(4, $item->quantite);

        // Check total count
        $count = $this->cartService->getCartCount();
        $this->assertEquals(4, $count);
    }

    public function test_remove_from_cart(): void
    {
        $this->actingAs($this->user);

        $this->cartService->addToCart($this->produit->id, 2);
        $this->assertCount(1, $this->cartService->getCartItems());

        $this->cartService->removeFromCart($this->produit->id);
        $this->assertCount(0, $this->cartService->getCartItems());
    }

    public function test_clear_cart(): void
    {
        $this->actingAs($this->user);

        $this->cartService->addToCart($this->produit->id, 2);
        $this->assertEquals(2, $this->cartService->getCartCount());

        $this->cartService->clearCart();
        $this->assertEquals(0, $this->cartService->getCartCount());
    }

    public function test_calculate_cart_total(): void
    {
        $this->actingAs($this->user);

        // Create second product
        $produit2 = Produit::factory()->create([
            'prix' => 500,
            'stock' => 10,
        ]);

        $this->cartService->addToCart($this->produit->id, 2); // 2 * 1000 = 2000
        $this->cartService->addToCart($produit2->id, 3);      // 3 * 500  = 1500

        $total = $this->cartService->calculateCartTotal();
        $this->assertEquals(3500, $total);
    }
}
