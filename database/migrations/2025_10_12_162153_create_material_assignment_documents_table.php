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
        Schema::create('material_assignment_documents', function (Blueprint $table) {
            $table->id();
            $table->string('file_name', 255)->comment('File name');
            $table->string('original_name', 255)->comment('Original file name');
            $table->string('file_path', 500)->nullable()->comment('File path in filesystem');
            $table->integer('file_size')->nullable()->comment('File size in bytes');
            $table->string('mime_type', 100)->nullable()->comment('MIME type of the file');
            $table->unsignedBigInteger('material_assignment_id')->comment('Material assignment reference');
            $table->unsignedBigInteger('uploaded_by_professional_id')->comment('Professional that uploaded the document');
            // FKs
            $table->foreign('material_assignment_id', 'material_assignment_documents_assignment_fk')->references('id')->on('material_assignments')->onDelete('cascade');
            $table->foreign('uploaded_by_professional_id', 'material_assignment_documents_uploader_fk')->references('id')->on('professionals')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_assignment_documents');
    }
};
