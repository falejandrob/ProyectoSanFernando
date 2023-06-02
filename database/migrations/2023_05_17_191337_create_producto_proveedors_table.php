<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_proveedors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pedido');
            $table->foreign('pedido')->references('id')->on('pedidos')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('lineaPedido');
            $table->foreign('lineaPedido')->references('id')->on('linea_pedidos')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('proveedor');
            $table->foreign('proveedor')->references('id')->on('proveedores')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_proveedors');
    }
};
