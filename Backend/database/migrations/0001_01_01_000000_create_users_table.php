<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla 1: roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PK
            $table->string('nombre', 50)->unique();
            $table->timestamps();
        });

        // Tabla 2: usuarios
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PK
            $table->foreignId('rol_id')->constrained('roles')->restrictOnDelete();
            $table->string('nombre_completo', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('usuarios');
        Schema::dropIfExists('roles');
    }
};
