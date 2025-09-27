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
        Schema::create('project_commission_assignment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_commission_id')->comment('Project/Commission reference');
            $table->unsignedBigInteger('professional_id')->comment('Professional reference');
            $table->date('assignment_date')->comment('Assignment date')->nullable();
            $table->string('status', 50)->comment('Assignment status')->nullable();
            $table->text('notes')->comment('Assignment notes')->nullable();;

            // FKs
            $table->foreign('project_commission_id')->references('id')->on('project_commission')->onDelete('cascade');
            $table->foreign('professional_id')->references('id')->on('professional')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_commission_assignment');
    }
};
