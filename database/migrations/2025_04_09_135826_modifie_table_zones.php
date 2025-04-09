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
        Schema::table('zones', function (Blueprint $table) {
            $table->double("lat_max")->nullable()->after("status");
            $table->double("lat_min")->nullable()->after("lat_max");
            $table->double("lon_max")->nullable()->after("lat_min");
            $table->double("lon_min")->nullable()->after("lon_max");

        });
        Schema::create("zone_livreur", function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('zone_id')->constrained()->onDelete('cascade');
            $table->foreignId('livreur_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zones', function (Blueprint $table) {
            //
        });
    }
};
