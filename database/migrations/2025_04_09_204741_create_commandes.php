<?php
use App\OrderStatus;
use App\FactureStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
            $table->string('status')->default(OrderStatus::PENDING->value);
            $table->string('adresse');
            $table->float("latitude")->nullable();
            $table->float('longitude')->nullable();
            $table->string('facture')->default(FactureStatus::PENDING->value);
            $table->foreignUuid('client_id')->references('id')->on('users');
            $table->foreignId("livreur_id")->nullable()->constrained('livreurs');
            $table->foreignId("zone_id")->constrained('zones');
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
