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
        Schema::create('material_assignments', function (Blueprint $table) {
            $table->id();
            
            // Professional reference
            $table->foreignId('professional_id')->constrained('professionals')->onDelete('cascade');
            
            // Size information with ENUMs for better data integrity
            $table->enum('shirt_size', ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '36', '38', '40', '42', '44', '46', '48', '50', '52', '54', '56'])->nullable()->comment('Shirt size');
            $table->enum('pants_size', ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '36', '38', '40', '42', '44', '46', '48', '50', '52', '54', '56'])->nullable()->comment('Pants size');
            $table->enum('shoe_size', ['34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56'])->nullable()->comment('Shoe size');
            
            // Assignment dates
            $table->date('assignment_date')->comment('Assignment date');
            
            // Assignment tracking
            $table->foreignId('assigned_by_professional_id')->nullable()->constrained('professionals')->onDelete('set null')->comment('Professional who assigned');
            
            // Additional information
            $table->text('observations')->nullable()->comment('Observations');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_assignments');
    }
};
