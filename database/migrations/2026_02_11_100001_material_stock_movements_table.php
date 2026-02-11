<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Movement log (entrada/sortida). Cancel·lar a movement reverts quantity then deletes record.
     */
    public function up(): void
    {
        Schema::create('material_stock_movements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('material_stock_item_id')->constrained('material_stock_items')->onDelete('cascade');
            $table->enum('type', ['Entrada', 'Sortida'])->comment('Movement type');
            $table->unsignedInteger('quantity')->comment('Amount (always positive)');
            $table->date('movement_date')->comment('Date of movement');
            $table->string('person', 255)->nullable()->comment('Proveedor (entrada) or persona receptora (sortida)');
            $table->foreignId('professional_id')->nullable()->constrained('professionals')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_stock_movements');
    }
};
