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
        Schema::create('solicitud_orden', function (Blueprint $table) {
            $table->id();
            $table->string('url_ci');
            $table->string('url_pdf');
            $table->string('estado')->default('pendiente'); // pendiente, aprobado, rechazado
            $table->string('comentario')->nullable();
            $table->string('respuesta')->nullable();
            $table->text('url_respuesta')->nullable();
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
