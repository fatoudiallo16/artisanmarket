<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            if (! Schema::hasColumn('produits', 'image')) {
                $table->string('image')->nullable()->after('stock');
            }
        });
    }

    public function down(): void
    {
        // La colonne `image` est définie par la migration de création de `produits`.
        // Cette migration ne la supprime donc pas pour éviter de retirer une colonne
        // dont elle n'est pas propriétaire.
    }
};
