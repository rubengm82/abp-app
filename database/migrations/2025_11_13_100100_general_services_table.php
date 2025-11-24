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

            // Relation to centers
            $table->foreignId('center_id')->nullable()->constrained('centers')->onDelete('cascade');
            
            // Service information
            $table->string('service_type', 100)->comment('Service type');
            
            // Manager and contact information
            $table->string('responsible', 255)->nullable()->comment('Responsible');
            $table->text('responsible_info')->nullable()->comment('Responsible Contact Info');
            
            // Planning
            $table->text('planning')->nullable()->comment('Planning');
            
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
