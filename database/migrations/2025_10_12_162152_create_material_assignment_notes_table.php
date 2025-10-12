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
        Schema::create('material_assignment_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_assignment_id')->comment('Material assignment reference');
            $table->text('notes')->comment('Material assignment notes');
            $table->unsignedBigInteger('created_by_professional_id')->comment('Professional that created the note');
            // FKs
            $table->foreign('material_assignment_id', 'material_assignment_notes_assignment_fk')->references('id')->on('material_assignments')->onDelete('cascade');
            $table->foreign('created_by_professional_id', 'material_assignment_notes_creator_fk')->references('id')->on('professionals')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_assignment_notes');
    }
};
