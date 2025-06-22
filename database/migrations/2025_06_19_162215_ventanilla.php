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
        Schema::create('ventanilla', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->foreignId('sucursal_id')->constrained('sucursal')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('estado')->default('disponible'); //
            // Estados posibles: disponible, ocupado, fuera de servicio
            
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
