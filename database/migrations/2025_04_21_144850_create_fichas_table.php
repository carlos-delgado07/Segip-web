<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fichas', function (Blueprint $table) {
            $table->id();
            
            $table->date('fecha');
            $table->time('hora');
            $table->string('ventanilla')->nullable(); // Ventanilla asignada, puede ser null si no se asigna
            

            // 👇 Campos adicionales
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('funcionario_id')->nullable(); // Funcionario que atendió la ficha
            $table->unsignedBigInteger('sucursal_id')->nullable(); // Sucursal donde se generó la ficha
            $table->unsignedBigInteger('ventanilla_id')->nullable(); // Ventanilla asignada
            $table->unsignedBigInteger('servicio_id')->nullable(); // Servicio asociado a la ficha
            $table->string('estado')->default('pendiente'); // Estados posibles: pendiente, atendida, cancelada
            $table->string('codigo')->unique();

            $table->timestamps();

            $table->unique(['user_id', 'fecha']); // Una ficha por día
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('funcionario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sucursal_id')->references('id')->on('sucursal')->onDelete('cascade');
            $table->foreign('ventanilla_id')->references('id')->on('ventanilla')->onDelete('cascade');
            $table->foreign('servicio_id')->references('id')->on('servicio')->onDelete('cascade');

        });
    }

    public function down(): void {
        Schema::dropIfExists('fichas');
    }
};
