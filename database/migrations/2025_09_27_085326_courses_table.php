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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            // Relation to centers
            $table->foreignId('center_id')->nullable()->constrained('centers')->onDelete('cascade');

            $table->string('training_center', 255)->comment('Training center name')->nullable();
            $table->string('forcem_code', 50)->comment('FORCEM code')->nullable();
            $table->integer('total_hours')->comment('Total course hours')->nullable();
            $table->enum('type', ['Formació Interna', 'Formació Externa', 'Formació Salut Laboral', 'Jorn', 'Taller', 'Seminari', 'Congrés'])->comment('Course type')->nullable();
            $table->enum('attendance_type', ['Presencial', 'Online', 'Mixto'])->comment('Attendance type: Presencial, Online, Mixto')->nullable();
            $table->string('training_name', 255)->comment('Training name')->nullable();
            $table->date('start_date')->comment('Course start date')->nullable();
            $table->date('end_date')->comment('Course end date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
