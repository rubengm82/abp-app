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
        Schema::create('hr_issues_follow_ups', function (Blueprint $table) {
            $table->id();
            
            // HR issue reference
            $table->foreignId('hr_issue_id')->constrained('hr_issues')->onDelete('cascade')->comment('HR issue reference');
            $table->foreignId('professional_id')->constrained('professionals')->onDelete('cascade')->comment('Professional reference');
            
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
        Schema::dropIfExists('hr_issues_follow_ups');
    }
};
