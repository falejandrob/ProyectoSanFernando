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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idUser');
            $table->foreign('idUser')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('fechaPedido');
            $table->dateTime('fechaPrevistaPedido');
            $table->string('justificacion');
            $table->integer('validado')->default(0);
            $table->string('estaPedido')->nullable();
            $table->string('eliminado')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
