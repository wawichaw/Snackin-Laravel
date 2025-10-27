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
        Schema::table('commentaires', function (Blueprint $table) {
            if (!Schema::hasColumn('commentaires', 'nom_visiteur')) {
                $table->string('nom_visiteur')->nullable()->after('utilisateur_id');
            }
            if (!Schema::hasColumn('commentaires', 'email_visiteur')) {
                $table->string('email_visiteur')->nullable()->after('nom_visiteur');
            }
            if (!Schema::hasColumn('commentaires', 'modere')) {
                $table->boolean('modere')->default(true)->after('email_visiteur');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commentaires', function (Blueprint $table) {
            if (Schema::hasColumn('commentaires', 'modere')) {
                $table->dropColumn('modere');
            }
            if (Schema::hasColumn('commentaires', 'email_visiteur')) {
                $table->dropColumn('email_visiteur');
            }
            if (Schema::hasColumn('commentaires', 'nom_visiteur')) {
                $table->dropColumn('nom_visiteur');
            }
        });
    }
};
