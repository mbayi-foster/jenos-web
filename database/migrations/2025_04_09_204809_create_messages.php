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
            $table->foreignId("commande_id")->constrained()->cascadeOnDelete();
            $table->boolean('get')->default(false);
            $table->enum("type", ["text", "photo"])->nullable(); //0 pour texte, 1 pour photo, 2 pour audio et 3 pour video
            $table->string('src')->nullable();
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
