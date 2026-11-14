<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla 3: eventos
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 150);
            $table->text('descripcion')->nullable();
            $table->string('lugar', 150);
            $table->dateTime('fecha_hora');
            $table->integer('aforo_maximo');
            $table->decimal('precio', 10, 2)->default(0.00);
            $table->enum('estatus', ['Activo', 'Cancelado', 'Finalizado'])->default('Activo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
