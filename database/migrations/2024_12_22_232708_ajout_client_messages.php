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
        Schema::table('messages', function (Blueprint $table) {
            $table->bigInteger('client')->unsigned();
            $table->foreign('client')->references('id')->on('clients');
        });
        Schema::table('commandes', function (Blueprint $table) {
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('zone_id')->constrained()->onDelete('cascade');
        });
        Schema::table('nombre_commandes', function (Blueprint $table) {
            $table->foreignId('plat_id')->constrained()->onDelete('cascade');
        });
        Schema::table('suggestions', function (Blueprint $table) {
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};
