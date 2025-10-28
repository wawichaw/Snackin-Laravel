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
            if (!Schema::hasColumn('commentaires', 'note')) {
                $table->integer('note')->nullable()->after('contenu');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commentaires', function (Blueprint $table) {
            if (Schema::hasColumn('commentaires', 'note')) {
                $table->dropColumn('note');
            }
        });
    }
};
