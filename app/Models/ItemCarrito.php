<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemCarrito extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'item_carritos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'carrito_id', 'producto_id', 'cantidad'
    ];

    /**
     * Get the product for the item.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Get the cart for the item.
     */
    public function carrito()
    {
        return $this->belongsTo(Carrito::class);
    }

    /**
     * Get the total price for the item.
     *
     * @return float
     */
    public function getTotalAttribute()
    {
        return $this->cantidad * $this->producto->precio;
    }
}
