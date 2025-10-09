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
        Schema::create('project_commission_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_commission_id')->comment('Project/Commission reference');
            $table->text('notes')->comment('Project/Commission notes');
            $table->unsignedBigInteger('professional_id')->comment('Professional that created the note');
            // FKs
            $table->foreign('project_commission_id')->references('id')->on('project_commissions')->onDelete('cascade');
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_commission_notes');
    }
};
