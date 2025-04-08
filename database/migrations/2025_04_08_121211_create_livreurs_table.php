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
            $table->String("prenom");
            $table->String("nom")->nullable();
            $table->string('email')->unique();
            $table->integer('phone')->nullable();
            $table->longText('photo')->nullable();
            $table->string('password');
            $table->double("location_lat")->default(0.0);
            $table->double("location_lon")->default(0.0);
            $table->boolean('status')->default(false);
            $table->boolean('busy')->default(true);
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
