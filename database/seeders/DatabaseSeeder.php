<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategorieSeeder::class,
            MarketplaceSeeder::class,
            ProduitArtisanalMaliSeeder::class,
        ]);

        $adminRole = Role::where('nom_role', 'admin')->first();

        if ($adminRole) {
            $admin = User::updateOrCreate(
                ['email' => 'admin@artisanmarket.test'],
                [
                    'name' => 'Admin',
                    'password' => Hash::make('Admin@12345'),
                    'role_id' => $adminRole->id,
                ]
            );

            $admin->load('role');
            $admin->syncProfileByRole();
        }
    }
}
