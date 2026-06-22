<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategorieSeeder::class,
        ]);

        $adminRole = Role::where('nom_role', 'admin')->first();

        if ($adminRole) {
            $admin = User::updateOrCreate(
                ['email' => 'admin@artisanmarket.test'],
                [
                    'name' => 'Admin',
                    'password' => 'Admin@12345',
                    'role_id' => $adminRole->id,
                ]
            );

            $admin->load('role');
            $admin->syncProfileByRole();
        }
    }
}
