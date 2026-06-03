<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([
            'bijoux', 'tissus', 'poterie', 'pot en terre cuite',
            'sculpture bois', 'cuir', 'instruments', 'maroquinerie',
            'art mural', 'vannerie', 'cosmetiques',
        ] as $name) {
            Categorie::firstOrCreate(['name' => $name]);
        }
    }
}
