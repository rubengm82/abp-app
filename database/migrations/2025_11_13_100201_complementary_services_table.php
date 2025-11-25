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
        Schema::create('complementary_services', function (Blueprint $table) {
            $table->id();
            
            // Center
            $table->foreignId('center_id')->nullable()->constrained('centers')->onDelete('cascade');

            // Service information
            $table->string('service_type', 255)->nullable()->comment('Service type');
            $table->string('service_responsible', 255)->nullable()->comment('Service responsible');
            
            // Service dates Redundant
            $table->date('start_date')->comment('Service start date');
            $table->date('end_date')->nullable()->comment('Service start date');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complementary_services');
    }
};
