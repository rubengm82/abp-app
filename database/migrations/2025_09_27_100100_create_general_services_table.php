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
        Schema::create('general_services', function (Blueprint $table) {
            $table->id();
            
            // Service information
            $table->string('service_type', 100)->nullable()->comment('Service type');
            
            // Professional references
            $table->foreignId('assigned_professional_id')->nullable()->constrained('professionals')->onDelete('set null')->comment('Assigned professional');
            $table->foreignId('contact_professional_id')->nullable()->constrained('professionals')->onDelete('set null')->comment('Contact professional');
            
            // External contact reference
            $table->foreignId('external_contact_id')->nullable()->constrained('external_contacts')->onDelete('set null')->comment('External contact reference');
            
            //FALTA START_DATE
            $table->date('start_date')->nullable()->comment('Service start date');
            // Service dates
            $table->date('end_date')->nullable()->comment('Service end date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_services');
    }
};
