<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Catégories à conserver
        $allowedCategories = ['bijoux', 'tissus', 'poterie', 'cuir'];

        // Récupérer les IDs des catégories à supprimer
        $categoriesToDelete = DB::table('categories')
            ->whereNotIn('name', $allowedCategories)
            ->pluck('id');

        if ($categoriesToDelete->isNotEmpty()) {
            // Supprimer les produits associés aux catégories indésirables
            DB::table('produits')
                ->whereIn('categorie_id', $categoriesToDelete)
                ->delete();

            // Supprimer les catégories indésirables
            DB::table('categories')
                ->whereIn('id', $categoriesToDelete)
                ->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cette migration ne peut pas être facilement annulée
        // car les données supprimées ne sont pas sauvegardées
        // Pour restaurer, il faudra relancer les seeders
    }
};
