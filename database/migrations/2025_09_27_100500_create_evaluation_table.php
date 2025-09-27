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
        Schema::create('evaluation', function (Blueprint $table) {
            $table->id();
            
            // Professional references
            $table->foreignId('evaluator_professional_id')->constrained('professional')->onDelete('cascade')->comment('Evaluator professional');
            $table->foreignId('evaluated_professional_id')->constrained('professional')->onDelete('cascade')->comment('Evaluated professional');
            
            // Evaluation information
            $table->date('evaluation_date')->comment('Evaluation date');
            $table->text('responses')->nullable()->comment('Evaluation responses');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation');
    }
};
