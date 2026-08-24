<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('washes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host_id')->constrained('users'); // Anfitrión
            $table->foreignId('washer_id')->constrained('users'); // Lavador
            $table->string('vehicle_type'); // Carro, Camión, Camioneta
            $table->string('plate_number')->nullable();
            $table->string('color')->nullable();
            $table->text('details')->nullable(); // Rayones, etc.
            $table->string('photo_path')->nullable(); // Foto como evidencia
            $table->decimal('price', 8, 2)->default(0); // Precio cobrado
            $table->decimal('washer_payment', 8, 2)->default(0); // Dinero invertido en pagar al lavador
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('washes');
    }
};
