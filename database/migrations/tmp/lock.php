Schema::create('locker', function (Blueprint $table) {
            $table->id();
            
            // Locker identification
            $table->string('locker_number', 10)->unique()->comment('Locker number');
            
            // Locker status
            $table->enum('status', ['Disponible', 'Ocupat', 'Manteniment'])->default('Disponible')->comment('Locker status');
            
            // Key information
            $table->string('key_code', 50)->nullable()->comment('Key code');
            
            $table->timestamps();
        });