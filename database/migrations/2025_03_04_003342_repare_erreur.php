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
        Schema::table("zones", function (Blueprint $table) {
            $table->dropForeign(['chef']);
            // Modifier la colonne pour permettre NULL
            $table->bigInteger('chef')->unsigned()->nullable()->change();
            // Ajouter une nouvelle contrainte de clé étrangère avec ON DELETE SET NULL
            $table->foreign('chef')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
