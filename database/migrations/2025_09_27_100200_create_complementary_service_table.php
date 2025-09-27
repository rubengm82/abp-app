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
        Schema::create('complementary_service', function (Blueprint $table) {
            $table->id();
            
            // Service information
            $table->string('service_type', 100)->nullable()->comment('Service type');
            $table->string('service_responsible', 255)->nullable()->comment('Service responsible (free text)');
            
            // Service dates Redundant
            $table->date('start_date')->nullable()->comment('Service start date');
            $table->date('end_date')->nullable()->comment('Service end date');
            
            // Documents
            $table->string('documents', 500)->nullable()->comment('Related documents');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complementary_service');
    }
};
