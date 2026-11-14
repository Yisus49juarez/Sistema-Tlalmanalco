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
    Schema::create('chats_soporte', function (Blueprint $table) {
        $table->id();
        $table->foreignId('sender_id')->constrained('usuarios')->cascadeOnDelete();
        $table->foreignId('receiver_id')->constrained('usuarios')->cascadeOnDelete();
        $table->text('mensaje');
        $table->boolean('leido')->default(false);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('chats_soporte');
}
};
