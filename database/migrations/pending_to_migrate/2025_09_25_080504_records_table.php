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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            
            // Professional reference
            $table->foreignId('professional_id')->constrained('professionals')->onDelete('cascade');
            
            // Record information
            $table->enum('type', ['Seguiment', 'Avaluació', 'Accident', 'Baixa_llarga', 'Observació'])->comment('Record type');
            $table->date('date')->comment('Record date');
            $table->text('description')->nullable()->comment('Record description');
            $table->text('comments')->nullable()->comment('Additional comments');
            $table->string('file', 500)->nullable()->comment('Attached file path');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
