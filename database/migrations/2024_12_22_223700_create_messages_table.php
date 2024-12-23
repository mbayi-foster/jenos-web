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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->longText('contenue')->nullable();
            $table->integer('expediteur')->default('1'); // 1 pour le livreur, 0 pour le client et 2 pour le gerant si possible
            $table->bigInteger('livreur')->unsigned();
            $table->foreign('livreur')->references('id')->on('users');
            $table->bigInteger('livraison')->unsigned();
            $table->foreign('livraison')->references('id')->on('livraisons');
            $table->boolean('status')->default(false);
            $table->integer('type')->default(0); //0 pour texte, 1 pour photo, 2 pour audio et 3 pour video
            $table->longText('src')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
       
    }
};
