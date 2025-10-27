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
        // Supprimer l'ancienne table et la recréer avec la bonne structure
        Schema::dropIfExists('commandes');
        
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('users')->restrictOnDelete()->restrictOnUpdate();
            $table->string('client_nom');
            $table->string('client_email');
            $table->text('details_json')->nullable();
            $table->string('status')->default('en_attente');
            $table->decimal('total_prix', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
