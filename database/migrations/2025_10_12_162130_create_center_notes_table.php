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
        Schema::create('center_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('center_id')->comment('Center reference');
            $table->text('notes')->comment('Center notes');
            $table->unsignedBigInteger('created_by_professional_id')->comment('Professional that created the note');
            // FKs
            $table->foreign('center_id', 'center_notes_center_fk')->references('id')->on('centers')->onDelete('cascade');
            $table->foreign('created_by_professional_id', 'center_notes_creator_fk')->references('id')->on('professionals')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('center_notes');
    }
};
