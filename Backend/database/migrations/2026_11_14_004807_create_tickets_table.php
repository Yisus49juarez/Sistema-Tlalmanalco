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
    Schema::create('tickets', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('usuarios')->cascadeOnDelete();
        $table->foreignId('evento_id')->constrained('eventos')->cascadeOnDelete();
        $table->string('folio_hash', 255)->unique();
        $table->enum('estatus_acceso', ['Valido', 'Escaneado'])->default('Valido');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
