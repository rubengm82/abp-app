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
        Schema::create('accidents', function (Blueprint $table) {
            $table->id();
            
            // Accident information
            $table->string('accident_type', 100)->nullable()->comment('Accident type');
            $table->date('start_date')->comment('Accident start date');
            $table->date('end_date')->nullable()->comment('Accident end date');
            $table->text('description')->nullable()->comment('Accident description');
            
            // Professional references
            $table->foreignId('reporting_professional_id')->constrained('professionals')->onDelete('cascade')->comment('Professional who reported');
            $table->foreignId('injured_professional_id')->constrained('professionals')->onDelete('cascade')->comment('Injured professional');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accidents');
    }
};
