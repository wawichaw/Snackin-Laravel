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
        // SQLite ne supporte pas bien dropColumn, donc on recrée la table
        // Sauvegarder les données existantes si nécessaire
        $existingData = [];
        if (Schema::hasTable('commandes')) {
            $existingData = \DB::table('commandes')->get()->toArray();
        }
        
        // Supprimer et recréer la table avec la bonne structure
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
        
        // Note: Les anciennes données ne seront pas restaurées car la structure est complètement différente
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurer l'ancienne structure
        Schema::dropIfExists('commandes');
        
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->restrictOnDelete()->restrictOnUpdate();
            $table->foreignId('biscuit_id')->constrained('biscuits')->restrictOnDelete()->restrictOnUpdate();
            $table->unsignedInteger('quantite');
            $table->date('date_commande');
            $table->timestamps();
        });
    }
};
