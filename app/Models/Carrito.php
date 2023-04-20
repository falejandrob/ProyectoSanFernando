<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'carritos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'estado'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'estado' => 'boolean'
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the cart.
     */
    public function items()
    {
        return $this->hasMany(ItemCarrito::class);
    }

    /**
     * Get the total number of items in the cart.
     *
     * @return int
     */
    public function getNumElementosAttribute()
    {
        return $this->items()->sum('cantidad');
    }

    /**
     * Determine if the cart is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->estado;
    }

    /**
     * Determine if the cart is inactive.
     *
     * @return bool
     */
    public function isInactive()
    {
        return ! $this->isActive();
    }

    /**
     * Deactivate the cart.
     *
     * @return void
     */
    public function deactivate()
    {
        $this->estado = false;
        $this->save();
    }

    /**
     * Activate the cart.
     *
     * @return void
     */
    public function activate()
    {
        $this->estado = true;
        $this->save();
    }
}

