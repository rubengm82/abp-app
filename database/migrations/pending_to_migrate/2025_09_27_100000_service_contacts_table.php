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
        Schema::create('service_contacts', function (Blueprint $table) {
            $table->id();
            
            // Service contact information
            $table->string('type', 100)->comment('Type: servicio_general, servicio_complementario, contacto_asistencial, contacto_general');
            $table->string('responsible', 255)->nullable()->comment('Responsible person (free text)');
            $table->string('phone', 20)->nullable()->comment('Contact phone');
            $table->string('email', 255)->nullable()->comment('Contact email');
            $table->text('observations')->nullable()->comment('Observations');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_contacts');
    }
};
