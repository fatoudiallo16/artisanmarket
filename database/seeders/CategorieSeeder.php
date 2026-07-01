<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $column = match (true) {
            Schema::hasColumn('categories', 'name') => 'name',
            Schema::hasColumn('categories', 'nom') => 'nom',
            default => 'nom_categorie',
        };

        foreach ([
            'bijoux', 'tissus', 'poterie', 'cuir',
        ] as $name) {
            Categorie::firstOrCreate(
                [$column => $name],
                ['slug' => \Illuminate\Support\Str::slug($name)]
            );
        }
    }
}
