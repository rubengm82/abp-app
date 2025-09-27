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
        Schema::create('work_follow_up', function (Blueprint $table) {
            $table->id();
            
            // Follow-up information
            $table->string('follow_up_type', 100)->nullable()->comment('Follow-up type');
            $table->date('follow_up_date')->comment('Follow-up date');
            
            // Professional references
            $table->foreignId('recorder_professional_id')->constrained('professional')->onDelete('cascade')->comment('Professional who recorded');
            $table->foreignId('professional_id')->constrained('professional')->onDelete('cascade')->comment('Professional being followed');
            
            // Follow-up details
            $table->string('topic', 255)->nullable()->comment('Follow-up topic');
            $table->text('comment')->nullable()->comment('Follow-up comment');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_follow_up');
    }
};
