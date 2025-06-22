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
        Schema::create('solicitud_brigada', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('contenido');
            $table->string('estado')->default('pendiente'); // pendiente, aprobado, rechazado
            $table->float('latitud')->nullable();
            $table->float('longitud')->nullable();
            $table->unsignedBigInteger('municipio_id');
            $table->foreign('municipio_id')->references('id')->on('municipio')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
