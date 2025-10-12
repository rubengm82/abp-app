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
        Schema::create('professional_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('professional_id')->comment('Professional reference');
            $table->text('notes')->comment('Professional notes');
            $table->unsignedBigInteger('created_by_professional_id')->comment('Professional that created the note');
            // FKs
            $table->foreign('professional_id', 'professional_notes_owner_fk')->references('id')->on('professionals')->onDelete('cascade');
            $table->foreign('created_by_professional_id', 'professional_notes_creator_fk')->references('id')->on('professionals')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_notes');
    }
};
