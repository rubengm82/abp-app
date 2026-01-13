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
        Schema::create('documents_component', function (Blueprint $table) {
            $table->id(); // Primary key

            $table->string('file_name')->comment('Hashed file name stored in filesystem');
            $table->string('original_name')->comment('Original file name uploaded by user');
            $table->string('file_path', 500)->nullable()->comment('Path where file is stored in filesystem');
            $table->integer('file_size')->nullable()->comment('File size in bytes');
            $table->string('mime_type', 100)->nullable()->comment('MIME type of the file');

            // Polymorphic relation: allows this document to belong to any model (Center, Project, etc.)
            $table->morphs('documentable'); // creates documentable_id and documentable_type

            // Professional who uploaded the document (optional)
            $table->foreignId('uploaded_by_professional_id')
                  ->nullable()
                  ->constrained('professionals')
                  ->nullOnDelete()
                  ->comment('Professional that uploaded the document');

            // Document type (enum)
            $table->enum('document_type', [
                'Organització del Centre',
                'Documents del Departament',
                'Memòries i Seguiment anual',
                'PRL',
                'Comitè Empresa',
                'Informes professionals',
                'Informes persones usuàries',
                'Qualitat i ISO',
                'Projectes',
                'Comissions',
                'Famílies',
                'Comunicació i Reunions',
                'Altres'
            ])->nullable()->comment('Type of document')->default('Altres');

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents_component');
    }
};
