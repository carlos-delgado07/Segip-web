<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fichas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('fecha');
            $table->time('hora');
            $table->integer('ventanilla');
            $table->string('codigo')->unique();

            // 👇 Campos adicionales
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'fecha']); // Una ficha por día
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('fichas');
    }
};
