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
            $table->binary('file_content')->nullable()->comment('File content as blob');
            $table->unsignedBigInteger('project_commission_id')->comment('Project/Commission reference');

            // FKs
            $table->foreign('project_commission_id')->references('id')->on('project_commissions')->onDelete('cascade');

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
