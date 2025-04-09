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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('prenom');
            $table->string('nom')->nullable();
            $table->string('email')->unique();
            $table->integer('phone')->nullable();
            $table->longText('photo')->nullable();
            $table->string('password');
            $table->boolean('status')->default(true);
            $table->string('adresse')->nullable();
            $table->float("location_lat")->nullable();
            $table->float('location_lon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
