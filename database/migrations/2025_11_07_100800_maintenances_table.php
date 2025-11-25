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
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            
            $table->string('name_maintenance', 100)->index();

            
            // *** Company that performs this maintenance will be a FK to the own schedule; for now, it is fictional *** TEMPORAL
            $table->string('responsible_maintenance', 100)->index()->comment('Person/Company who performs this maintenance');
            
            // Maintenance Center FK
            $table->foreignId('center_id')->nullable()->constrained('centers')->onDelete('cascade');
            
            $table->text('description')->nullable()->comment('Maintenance description');
            
            // Maintenance information
            $table->date('opening_date_maintenance')->comment('Maintenance opening date');
            $table->date('ending_date_maintenance')->nullabble()->comment('Maintenance opening date');
            // $table->date('end_date')->nullable()->comment('Maintenance end date');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
