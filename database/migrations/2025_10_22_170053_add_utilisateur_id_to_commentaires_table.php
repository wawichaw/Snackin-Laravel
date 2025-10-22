<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('commentaires', function (Blueprint $table) {
            // colonne nullable si l’utilisateur n’est pas connecté
            $table->unsignedBigInteger('utilisateur_id')->nullable()->after('biscuit_id');

            // Si ta table s’appelle "utilisateurs" (et pas "users"), dé-commente la contrainte ci-dessous
            // attention: sous SQLite les contraintes FK peuvent être capricieuses; tu peux la laisser commentée
            // $table->foreign('utilisateur_id')->references('id')->on('utilisateurs')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('commentaires', function (Blueprint $table) {
            // si tu as créé une FK, droppe-la d’abord
            // $table->dropForeign(['utilisateur_id']);
            $table->dropColumn('utilisateur_id');
        });
    }
};
