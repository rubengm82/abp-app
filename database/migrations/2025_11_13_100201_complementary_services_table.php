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
            $table->date('end_date')->nullable()->comment('Service end date');

            $table->text('description')->nullable()->comment('Issue description');

            // Workflow status
            $table->enum('status', ['Obert', 'Tancat'])->default('Obert')->comment('Status: Obert, Tancat');
            // Record active status (for activate/deactivate)
            $table->integer('active_status')->default(1)->comment('Active status: 1 active, 0 deactivated');
           
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
