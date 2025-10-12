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
        Schema::create('professional_documents', function (Blueprint $table) {
            $table->id();
            $table->string('file_name', 255)->comment('File name');
            $table->string('original_name', 255)->comment('Original file name');
            $table->binary('file_content')->nullable()->comment('File content as blob');
            $table->integer('file_size')->nullable()->comment('File size in bytes');
            $table->string('mime_type', 100)->nullable()->comment('MIME type of the file');
            $table->unsignedBigInteger('professional_id')->comment('Professional reference');
            $table->unsignedBigInteger('uploaded_by_professional_id')->comment('Professional that uploaded the document');
            // FKs
            $table->foreign('professional_id', 'professional_documents_owner_fk')->references('id')->on('professionals')->onDelete('cascade');
            $table->foreign('uploaded_by_professional_id', 'professional_documents_uploader_fk')->references('id')->on('professionals')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_documents');
    }
};
