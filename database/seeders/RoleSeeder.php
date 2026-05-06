<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['client', 'vendeur', 'admin'] as $roleName) {
            Role::firstOrCreate(['nom_role' => $roleName]);
        }
    }
}
