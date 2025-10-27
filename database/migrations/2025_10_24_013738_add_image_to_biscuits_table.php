<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations
     * 
     * @return void
     */
    

    public function up() {
        if (!Schema::hasColumn('biscuits', 'image')) {
            Schema::table('biscuits', function(Blueprint $table) {
                $table->string('image')->nullable()->after('nom_biscuit');
            });
        }
    }
    /**
     * Reverse the migrations
     * 
     * @return void
     */
    public function down() 
    {
        Schema::table('biscuits', function(Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};