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
    Schema::create('tareas_logisticas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('evento_id')->nullable()->constrained('eventos')->nullOnDelete();
        $table->foreignId('staff_id')->constrained('usuarios')->cascadeOnDelete();
        $table->foreignId('asignado_por')->constrained('usuarios')->cascadeOnDelete();
        $table->string('titulo', 150);
        $table->text('descripcion')->nullable();
        $table->enum('estatus', ['Pendiente', 'En_Progreso', 'Completada'])->default('Pendiente');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('tareas_logisticas');
}
};
