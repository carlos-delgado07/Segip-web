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
        Schema::create('ventanilla_servicio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ventanilla_id')->constrained('ventanilla')->onDelete('cascade');
            $table->foreignId('servicio_id')->constrained('servicio')->onDelete('cascade');
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
