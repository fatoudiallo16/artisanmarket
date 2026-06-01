<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();        
            $table->string('nom');
            $table->longText('description')->nullable();
            $table->decimal('prix', 10, 2);
            $table->integer('stock');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->foreignId('vendeur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('categorie_id')->constrained()->onDelete('cascade');
            $table->enum('status', [
            'pending',
            'approved',
            'rejected'
            ])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produits');
    }
};
