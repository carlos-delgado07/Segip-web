<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('brigada_solicitud_nueva', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 255);
            $table->text('contenido')->nullable();
            $table->decimal('latitud', 10, 7);
            $table->decimal('longitud', 10, 7);
            $table->string('estado', 50)->default('pendiente');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');

            $table->foreign('municipio_id')
                  ->references('id')->on('municipio')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('brigada_solicitud_nueva');
    }
};
