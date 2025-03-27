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
        Schema::table('commandes', function (Blueprint $table) {
            if (Schema::hasColumn('commandes', 'status')) {
                $table->dropColumn('status');
            }
            $table->dropForeign(['zone_id']);
            $table->boolean("status")->default(false)->after("prix");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn("zone_id");
        });
    }
};
