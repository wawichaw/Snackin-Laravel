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
        Schema::table('biscuits', function (Blueprint $table) {
            $table->foreignId('saveur_id')->nullable()->constrained('saveurs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('biscuits', function (Blueprint $table) {
            $table->dropForeign(['saveur_id']);
            $table->dropColumn('saveur_id');
        });
    }
};
