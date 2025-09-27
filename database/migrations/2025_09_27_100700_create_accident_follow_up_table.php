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
        Schema::create('accident_follow_up', function (Blueprint $table) {
            $table->id();
            
            // Accident reference
            $table->foreignId('accident_id')->constrained('accident')->onDelete('cascade')->comment('Accident reference');
            $table->foreignId('professional_id')->constrained('professional')->onDelete('cascade')->comment('Professional reference');
            
            // Follow-up information
            $table->date('follow_up_date')->comment('Follow-up date');
            $table->text('description')->nullable()->comment('Follow-up description');
            $table->text('notes')->nullable()->comment('Additional notes');
            $table->string('documents', 500)->nullable()->comment('Related documents');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accident_follow_up');
    }
};
