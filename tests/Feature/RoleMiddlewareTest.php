<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    private User $clientUser;
    private User $vendeurUser;
    private User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // Create Roles
        $clientRole = Role::firstOrCreate(['nom_role' => 'client']);
        $vendeurRole = Role::firstOrCreate(['nom_role' => 'vendeur']);
        $adminRole = Role::firstOrCreate(['nom_role' => 'admin']);

        // Create Users
        $this->clientUser = User::factory()->create(['role_id' => $clientRole->id]);
        $this->vendeurUser = User::factory()->create(['role_id' => $vendeurRole->id]);
        $this->adminUser = User::factory()->create(['role_id' => $adminRole->id]);
        
        // Synchronize profiles for roles
        $this->clientUser->syncProfileByRole();
        $this->vendeurUser->syncProfileByRole();
        $this->adminUser->syncProfileByRole();
    }

    public function test_guest_can_access_welcome_page(): void
    {
        $response = $this->get(route('welcome'));
        $response->assertStatus(200);
    }

    public function test_guest_is_redirected_from_auth_routes(): void
    {
        // /home is protected by auth middleware
        $response = $this->get(route('home'));
        $response->assertRedirect('/login');
    }

    public function test_client_can_access_client_dashboard(): void
    {
        $response = $this->actingAs($this->clientUser)->get(route('client.dashboard'));
        $response->assertStatus(200);
    }

    public function test_client_cannot_access_vendeur_dashboard(): void
    {
        $response = $this->actingAs($this->clientUser)->get(route('vendeur.dashboard'));
        $response->assertStatus(403);
    }

    public function test_client_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->clientUser)->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_vendeur_can_access_vendeur_dashboard(): void
    {
        $response = $this->actingAs($this->vendeurUser)->get(route('vendeur.dashboard'));
        $response->assertStatus(200);
    }

    public function test_vendeur_cannot_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->vendeurUser)->get(route('admin.dashboard'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    public function test_admin_can_approve_vendeur(): void
    {
        $vendeur = \App\Models\Vendeur::create([
            'user_id' => $this->vendeurUser->id,
            'id_utilisateur' => $this->vendeurUser->id,
            'name' => $this->vendeurUser->name,
            'nom_boutique' => 'Ma Boutique',
            'statut' => 'en_attente',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->from(route('admin.dashboard'))
            ->put(route('admin.vendeurs.update', $vendeur), [
                'statut' => 'approuve',
            ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertEquals('approuve', $vendeur->fresh()->statut);
    }

    public function test_admin_can_access_users_index(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.users.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.utilisateurs.index');
    }

    public function test_client_cannot_access_users_index(): void
    {
        $response = $this->actingAs($this->clientUser)->get(route('admin.users.index'));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_vendeurs_index(): void
    {
        $response = $this->actingAs($this->adminUser)->get(route('admin.vendeurs.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.vendeurs.index');
    }

    public function test_client_cannot_access_vendeurs_index(): void
    {
        $response = $this->actingAs($this->clientUser)->get(route('admin.vendeurs.index'));
        $response->assertStatus(403);
    }
}
