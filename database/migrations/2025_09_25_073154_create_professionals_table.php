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

                // Relation to centers
                $table->foreignId('center_id')->nullable()->constrained('centers')->onDelete('cascade');

                // Professional info
                $table->enum('role', ['Directiu', 'Administració', 'Tècnic'])->nullable()->comment('Professional role');
                $table->string('name', 100)->comment('First name');
                $table->string('surname1', 100)->comment('First surname');
                $table->string('surname2', 100)->nullable()->comment('Second surname');
                $table->string('dni', 100)->unique()->comment('DNI');

                // Contact info
                $table->string('phone', 20)->nullable()->comment('Contact phone');
                $table->string('email', 255)->nullable()->unique()->comment('Email address');
                $table->string('address', 500)->nullable()->comment('Address');

                // Employment status
                $table->enum('employment_status', ['Actiu', 'Suplència', 'Baixa', 'No contractat'])->nullable()->comment('Employment status');

                // Additional info
                $table->text('cvitae')->nullable()->comment('Curriculum vitae');
                $table->string('user', 50)->unique()->nullable()->comment('Login username');
                $table->string('password', 255)->nullable()->comment('Password hash');
                $table->string('locker_num',50)->nullable()->comment('Locker number');
                $table->string('key_code', 50)->nullable()->comment('Key code');
                $table->integer('status')->nullable()->comment('Active status');

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
