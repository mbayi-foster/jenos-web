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
        //
        Schema::create("commande_panier", function (Blueprint $table) {
        $table->foreignId("commande_id")->constrained()->cascadeOnDelete();
        $table->foreignId("panier_id")->constrained()->cascadeOnDelete();
        });

        Schema::table('commandes', function (Blueprint $table){
            $table->bigInteger('livreur')->unsigned()->after('mois')->nullable();
            $table->foreign('livreur')->references('id')->on('users');
            $table->dropColumn('livraison');
            $table->string('livraison')->default('not yet'); 
            /*
            pour les livraison on a :
            not yet
            progress
            done
            */
            $table->boolean('confirm')->default(false);
        });

        Schema::table('paniers', function(Blueprint $table){
            $table->dropColumn('commander');
            $table->boolean('status')->default(false)->after('qte');
        });
        Schema::dropIfExists('commande_plat');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commande_plat');
    }
};
