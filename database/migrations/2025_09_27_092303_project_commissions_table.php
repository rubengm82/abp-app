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
        Schema::create('project_commissions', function (Blueprint $table) {
            $table->id();

            // Relation to centers
            $table->foreignId('center_id')->nullable()->constrained('centers')->onDelete('cascade');

            $table->String('name', 255)->comment('Project/Commission name');
            $table->date('start_date')->comment('Start date')->nullable();
            $table->date('estimated_end_date')->comment('Estimated end date')->nullable();
            $table->unsignedBigInteger('responsible_professional_id')->comment('Responsible professional');
            $table->text('description')->comment('Project description')->nullable();
            $table->enum('type', ['Projecte', 'Comissió'])->comment('Type: Projecte, Comissió')->nullable();
            $table->enum('status', ['Actiu', 'Inactiu'])->comment('Status: Actiu, Inactiu')->nullable();
            // FKs
            $table->foreign('responsible_professional_id')->references('id')->on('professionals')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_commissions');
    }
};
