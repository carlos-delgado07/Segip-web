<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('verificaciones_documentos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->nullable()->constrained('users')->onDelete('set null');
        $table->string('resultado'); // válido o inválido
        $table->timestamp('created_at')->useCurrent(); // fecha_verificacion
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verificaciones_documentos');
    }
};
