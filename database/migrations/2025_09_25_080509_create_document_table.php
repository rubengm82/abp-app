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
        Schema::create('document', function (Blueprint $table) {
            $table->id();
            
            // Professional reference
            $table->foreignId('professional_id')->constrained('professional')->onDelete('cascade');
            
            // Document information
            $table->string('type', 100)->comment('Document type');
            $table->date('date')->nullable()->comment('Document date');
            $table->string('filename', 255)->comment('Document filename');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document');
    }
};
