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
            $table->integer('ventanilla');
            

            // 👇 Campos adicionales
            $table->string('nombres')->nullable();
            $table->string('apellidos')->nullable();
            $table->unsignedBigInteger('ciudadano_id');
            $table->unsignedBigInteger('funcionario_id'); // Funcionario que atendió la ficha
            $table->unsignedBigInteger('sucursal_id'); // Sucursal donde se generó la ficha
            $table->unsignedBigInteger('ventanilla_id'); // Ventanilla asignada
            $table->unsignedBigInteger('servicio_id'); // Servicio asociado a la ficha
            $table->string('estado')->default('pendiente'); // Estados posibles: pendiente, atendida, cancelada
            $table->string('codigo')->unique();

            $table->timestamps();

            $table->unique(['ciudadano_id', 'fecha']); // Una ficha por día
            $table->foreign('ciudadano_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('fichas');
    }
};
