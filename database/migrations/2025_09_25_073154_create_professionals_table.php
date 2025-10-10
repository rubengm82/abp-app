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
        if (!Schema::hasTable('professionals')) {
            Schema::create('professionals', function (Blueprint $table) {
                $table->id();
                
                // Center reference
                $table->foreignId('center_id')->nullable()->constrained('centers')->onDelete('cascade');
                
                // Professional information
                $table->enum('role', ['Directiu', 'Administració', 'Tècnic'])->comment('Professional role')->nullable();
                $table->string('name', 100)->comment('First name');
                $table->string('surname1', 100)->comment('First surname');
                $table->string('surname2', 100)->nullable()->comment('Second surname');
                $table->string('dni', 100)->comment('dni');
                
                // Contact information
                $table->string('phone', 20)->nullable()->comment('Contact phone');
                $table->string('email', 255)->nullable()->comment('Email address');
                $table->string('address', 500)->nullable()->comment('Address');
                
                // Estado laboral (en catalán, incluyendo opción de trabajador no contratado)
                $table->enum('employment_status', ['Actiu', 'Suplència', 'Baixa', 'No contractat'])->comment('Estat laboral')->nullable();
                
                // Additional information
                $table->text('cvitae')->nullable()->comment('Curriculum vitae');
                $table->string('login', 50)->unique()->nullable()->comment('Login username');
                $table->string('password', 255)->nullable()->comment('Password hash');
                
                // Key information (moved from lockers table)
                $table->string('key_code', 50)->nullable()->comment('Key code');

                $table->integer('status')->nullable();

                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professionals');
    }
};
