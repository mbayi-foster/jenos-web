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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('ticket');
            $table->float('prix');
            $table->string("note")->nullable();
            $table->boolean('status')->default(false);
            $table->string('adresse');
            $table->float("location_lat")->nullable();
            $table->float('location_lon')->nullable();
            $table->enum('livraison', ['null', 'progress', 'finish'])->default("null");
            $table->enum('paiement', ['cash', 'carte', 'bank', 'mobile', 'paypal'])->nullable();
            $table->boolean('facture')->default(false);
            $table->boolean('confirm')->default(false);
            $table->foreignId("client_id")->constrained()->cascadeOnDelete();
            $table->foreignId("livreur_id")->constrained()->cascadeOnDelete();
            $table->foreignId("zone_id")->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
