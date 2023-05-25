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
        Schema::create('fecha_maxima_pedidos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fechaMinima');
            $table->dateTime('fechaMaxima');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fecha_maxima_pedidos');
    }
};
