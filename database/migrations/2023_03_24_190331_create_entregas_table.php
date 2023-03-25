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
        Schema::create('entregas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idProveedores');
            $table->foreign('idProveedores')->references('id')->on('proveedores')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('idPedidos');
            $table->foreign('idPedidos')->references('id')->on('pedidos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('descripcion');
            $table->date('fecha');
            $table->binary('foto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entregas');
    }
};
