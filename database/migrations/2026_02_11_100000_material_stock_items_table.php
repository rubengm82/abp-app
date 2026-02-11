<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Items (product types) and current quantity per center. No unique on name; duplicates allowed.
     */
    public function up(): void
    {
        Schema::create('material_stock_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('center_id')->nullable()->constrained('centers')->onDelete('cascade');
            $table->string('name', 255)->comment('Item name');
            $table->integer('quantity')->default(0)->comment('Current stock (can be negative)');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_stock_items');
    }
};
