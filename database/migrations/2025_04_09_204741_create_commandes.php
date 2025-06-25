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
            $table->float("location_lat")->nullable();
            $table->float('location_lon')->nullable();
            $table->string('livraison')->default("null"); // ['null', 'progress', 'field', 'finish']
            $table->string('paiement')->nullable(); //['cash', 'carte', 'bank', 'mobile', 'paypal']
            $table->string('facture')->default(FactureStatus::PENDING->value);
            $table->foreignId("client_id")->constrained()->cascadeOnDelete();
            $table->foreignId("livreur_id")->nullable()->constrained()->cascadeOnDelete();
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
