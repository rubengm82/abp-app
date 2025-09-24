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
        Schema::create('locker', function (Blueprint $table) {
            $table->id();
            
            // Locker identification
            $table->string('locker_number', 10)->unique()->comment('Locker number');
            
            // Locker status
            $table->enum('status', ['Disponible', 'Ocupat', 'Manteniment'])->default('Disponible')->comment('Locker status');
            
            // Key information
            $table->string('key_code', 50)->nullable()->comment('Key code');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locker');
    }
};
