<?php

namespace Database\Factories;

use App\Models\Vendeur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vendeur>
 */
class VendeurFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = \App\Models\User::factory();
        return [
            'id_utilisateur' => $user,
            'user_id' => $user,
            'statut' => 'approuve',
            'name' => $this->faker->name(),
            'nom_boutique' => $this->faker->company() . ' Boutique',
        ];
    }
}
