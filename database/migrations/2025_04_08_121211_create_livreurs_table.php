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
        Schema::create('livreurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('prenom');
            $table->string('nom')->nullable();
            $table->string('phone')->nullable();
            $table->longText('photo')->nullable();
            $table->boolean('status')->default(true);
            $table->string('adresse')->nullable();
            $table->string('commune')->nullable();
            $table->float("location_lat")->nullable();
            $table->float('location_lon')->nullable();
            $table->boolean('busy')->default(false);
            $table->foreignId('zone_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livreurs');
    }
};
