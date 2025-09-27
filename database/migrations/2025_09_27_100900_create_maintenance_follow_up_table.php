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
        Schema::create('maintenance_follow_up', function (Blueprint $table) {
            $table->id();
            
            // Maintenance reference
            $table->foreignId('maintenance_id')->constrained('maintenance')->onDelete('cascade')->comment('Maintenance reference');
            $table->foreignId('professional_id')->constrained('professional')->onDelete('cascade')->comment('Professional reference');
            
            // Follow-up information
            $table->text('description')->nullable()->comment('Follow-up description');
            $table->string('documents', 500)->nullable()->comment('Related documents');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_follow_up');
    }
};
