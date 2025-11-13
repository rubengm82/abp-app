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
        Schema::create('evaluation_observations', function (Blueprint $table) {
            $table->id();
            
            // Reference to evaluation group via UUID
            $table->uuid('evaluation_uuid')->comment('Evaluation UUID reference to group evaluations');
            
            // Observation text
            $table->text('observation')->nullable()->comment('Observation/comment for the evaluation');
            
            $table->timestamps();
            
            // Index for faster lookups ¬.¬
            $table->index('evaluation_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_observations');
    }
};
