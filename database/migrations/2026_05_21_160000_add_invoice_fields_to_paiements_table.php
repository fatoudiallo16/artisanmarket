<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            if (!Schema::hasColumn('paiements', 'numero_facture')) {
                $table->string('numero_facture')->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('paiements', 'facture_pdf')) {
                $table->string('facture_pdf')->nullable()->after('statut');
            }
        });
    }

    public function down(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            if (Schema::hasColumn('paiements', 'facture_pdf')) {
                $table->dropColumn('facture_pdf');
            }
            if (Schema::hasColumn('paiements', 'numero_facture')) {
                $table->dropColumn('numero_facture');
            }
        });
    }
};
