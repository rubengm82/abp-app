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
        Schema::create('external_contacts', function (Blueprint $table) {
            $table->id();
            
            // Contact type and reason
            $table->string('external_contact_type', 100)->nullable()->comment('External contact type');
            $table->string('service_reason', 255)->nullable()->comment('Service reason');
            
            // Company information
            $table->string('company', 255)->nullable()->comment('Company name');
            $table->string('department', 255)->nullable()->comment('Department');
            
            // Contact person information
            $table->string('name', 255)->nullable()->comment('Contact name');
            $table->string('surname', 255)->nullable()->comment('Contact surname');
            
            // Contact details
            $table->string('link', 500)->nullable()->comment('Link/Enlace');
            $table->string('phone', 20)->nullable()->comment('Contact phone');
            $table->string('email', 255)->nullable()->comment('Contact email');
            
            // Additional information
            $table->text('observations')->nullable()->comment('Observations');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_contacts');
    }
};
