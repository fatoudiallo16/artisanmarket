<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('paniers')) {
            Schema::create('paniers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();
            });

            return;
        }

        Schema::table('paniers', function (Blueprint $table) {
            if (!Schema::hasColumn('paniers', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained('users')->onDelete('cascade');
            }
        });

        $this->dropForeignIfExists('paniers', 'paniers_produit_id_foreign');

        Schema::table('paniers', function (Blueprint $table) {
            foreach (['quantite', 'prix_unitaire', 'produit_id'] as $column) {
                if (Schema::hasColumn('paniers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paniers', function (Blueprint $table) {
            if (!Schema::hasColumn('paniers', 'quantite')) {
                $table->integer('quantite')->default(1);
            }

            if (!Schema::hasColumn('paniers', 'prix_unitaire')) {
                $table->decimal('prix_unitaire', 8, 2)->default(0);
            }

            if (!Schema::hasColumn('paniers', 'produit_id')) {
                $table->foreignId('produit_id')->nullable()->constrained('produits')->nullOnDelete();
            }
        });
    }

    private function dropForeignIfExists(string $table, string $constraint): void
    {
        $database = DB::getDatabaseName();

        $exists = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('CONSTRAINT_SCHEMA', $database)
            ->where('TABLE_NAME', $table)
            ->where('CONSTRAINT_NAME', $constraint)
            ->exists();

        if ($exists) {
            Schema::table($table, function (Blueprint $blueprint) use ($constraint) {
                $blueprint->dropForeign($constraint);
            });
        }
    }
};
