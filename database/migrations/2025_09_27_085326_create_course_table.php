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
        Schema::create('course', function (Blueprint $table) {
            $table->id();
            $table->String('training_center', 255)->comment('Training center name')->nullable();
            $table->String('forcem_code', 50)->comment('FORCEM code')->nullable();
            $table->integer('total_hours')->comment('Total course hours')->nullable();
            $table->String('type', 100)->comment('Course type')->nullable();
            $table->enum('attendance_type', ['Presencial', 'Online', 'Mixto'])->comment('Attendance type: Presencial, Online, Mixto')->nullable();
            $table->String('training_name', 255)->comment('Training name')->nullable();
            $table->String('workshop', 255)->comment('Workshop name')->nullable();
            $table->String('conference_day', 255)->comment('Conference day')->nullable();
            $table->String('congress', 255)->comment('Congress name')->nullable();
            $table->String('attendee', 255)->comment('Attendee name')->nullable();
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
        Schema::dropIfExists('course');
    }
};
