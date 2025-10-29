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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            
            // Professional references
            $table->foreignId('evaluator_professional_id')->constrained('professionals')->onDelete('cascade')->comment('Evaluator professional');
            $table->foreignId('evaluated_professional_id')->constrained('professionals')->onDelete('cascade')->comment('Evaluated professional');
            
            $table->foreignId('question_id')->constrained('quiz')->onDelete('cascade')->comment('Question ID from quiz table');
            $table->integer('answer')->comment('Answer value from 0 to 3'); 
            $table->uuid('evaluation_uuid')->comment('Unique evaluation ID for grouping records');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
