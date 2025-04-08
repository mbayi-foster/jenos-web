<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('localisation');
            $table->dropColumn('confirm');
            $table->dropColumn('classer');
            $table->dropColumn('livraison');
            $table->double("location_lat")->nullable()->after('adresse');
            $table->double("location_lon")->nullable()->after('location_lat');
            /* type de livraison */
            $table->enum('livraison', ['null', 'progress', 'finish'])->default('null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            //
        });
    }
};
