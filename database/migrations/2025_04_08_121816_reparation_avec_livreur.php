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



        /* changements de la table messages */
        Schema::table('messages', function (Blueprint $table) {

            /* supression des foreigns */
            if (Schema::hasColumn('messages', 'livreur')) {
                $table->dropForeign(['livreur']);
                $table->dropColumn('livreur');
            }
            if (Schema::hasColumn('messages', 'livraison')) {
                $table->dropForeign(['livraison']);
                $table->dropColumn('livraison');
            }
            if (Schema::hasColumn('messages', 'client')) {
                $table->dropForeign(['client']);
                $table->dropColumn('client');
            }
            // $table->dropForeign(['livreur', 'livraison', 'client']);


            /* supression des colonnes */
            $table->dropColumn('expediteur');

            $table->bigInteger('commande')->unsigned()->after('contenue');
            $table->foreign('commande')->references('id')->on('commandes');
        });

        /* changment de la table commande */
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropForeign('livreur');
            $table->dropColumn('livreur');

            $table->bigInteger('livreur')->unsigned()->after('contenue');
            $table->foreign('livreur')->references('id')->on('livreurs');

            $table->boolean("confirm")->default(false);

        });

        //supression des tables
        Schema::dropIfExists('livraisons');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
