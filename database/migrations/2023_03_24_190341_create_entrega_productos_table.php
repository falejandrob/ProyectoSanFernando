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
        Schema::create('entrega_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idProducto');
            $table->foreign('idProducto')->references('id')->on('productos')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('idProfesor');
            $table->foreign('idProfesor')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('IdPedido');
            $table->foreign('IdPedido')->references('id')->on('pedidos')->onDelete('cascade')->onUpdate('cascade');
            $table->double('cantidad');
            $table->double('importe');
            $table->integer('iva');
            $table->double('importeIva');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrega_productos');
    }
};
