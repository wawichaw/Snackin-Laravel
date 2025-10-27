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
        Schema::table('commandes', function (Blueprint $table) {
            if (!Schema::hasColumn('commandes', 'client_nom')) {
                $table->string('client_nom')->nullable()->after('id');
            }
            if (!Schema::hasColumn('commandes', 'client_email')) {
                $table->string('client_email')->nullable()->after('client_nom');
            }
            if (!Schema::hasColumn('commandes', 'details_json')) {
                $table->text('details_json')->nullable()->after('client_email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            if (Schema::hasColumn('commandes', 'details_json')) {
                $table->dropColumn('details_json');
            }
            if (Schema::hasColumn('commandes', 'client_email')) {
                $table->dropColumn('client_email');
            }
            if (Schema::hasColumn('commandes', 'client_nom')) {
                $table->dropColumn('client_nom');
            }
        });
    }
};