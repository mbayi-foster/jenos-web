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
        /* pour les types
        0 = mobile money
        1 = carte de credit etc
        */
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->foreignId("client_id")->constrained()->cascadeOnDelete();
            $table->integer('type')->default(0);
            $table->string("numero");
            $table->string("date")->nullable();
            $table->string("pin")->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
