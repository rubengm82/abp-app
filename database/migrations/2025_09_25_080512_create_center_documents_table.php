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
        Schema::create('center_documents', function (Blueprint $table) {
            $table->id();
            
            // Document information
            $table->string('type', 100)->comment('Document type');
            $table->date('date')->nullable()->comment('Document date');
            $table->text('description')->nullable()->comment('Document description');
            
            // Professional reference (who uploaded)
            $table->foreignId('professional_id')->nullable()->constrained('professional')->onDelete('set null');
            
            // Document path
            $table->string('documents', 500)->nullable()->comment('Document path');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('center_documents');
    }
};
