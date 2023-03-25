<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        'idProducto',
        'idProfesor',
        'idPedido',
        'Cantidad',
        'Cantidad',
        'importe',
        'iva',
        'importeIva'
    ];
}