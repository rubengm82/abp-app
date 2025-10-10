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
        Schema::create('project_commission_documents', function (Blueprint $table) {
            $table->id();
            $table->string('file_name', 255)->comment('File name');
            $table->string('original_name', 255)->comment('Original file name');
            $table->binary('file_content')->nullable()->comment('File content as blob');
            $table->integer('file_size')->nullable()->comment('File size in bytes');
            $table->string('mime_type', 100)->nullable()->comment('MIME type of the file');
            $table->unsignedBigInteger('project_commission_id')->comment('Project/Commission reference');
            $table->unsignedBigInteger('professional_id')->comment('Professional reference');
            // FKs REVISAR SI NECESARIO BORRAR EN CASCADA
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
        Schema::dropIfExists('project_commission_documents');
    }
};
