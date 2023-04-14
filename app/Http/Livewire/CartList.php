<?php

namespace App\Http\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;

class CartList extends Component
{
    //
    protected $listeners = ['cart_update' =>'render'];
    public $cart;
    public $rowId;
    public function render()
    {
        $this->cart = Cart::content();
        $this->rowId = null;
        //@dd($this->cart);
        return view('livewire.cart-list', ['cart'=>$this->cart]);
    }

    public function removeFromCart($productoCarritoJson){
        $productoCarrito = json_decode($productoCarritoJson);
        //@dd($productoCarrito);
        $this->rowId = $productoCarrito->rowId;
        Cart::remove($this->rowId);
        $this->emit('product_listeners');
    }
    public function restElementToProduct($productoCarritoJson){
        $productoCarrito = json_decode($productoCarritoJson);
        //@dd($productoCarrito);
        $this->rowId = $productoCarrito->rowId;
        $this->cart = Cart::get($this->rowId);
        Cart::update($this->rowId, $this->cart->qty-1);
    }
    public function addElementToProduct($productoCarritoJson){
        $productoCarrito = json_decode($productoCarritoJson);
        //@dd($productoCarrito);
        $this->rowId = $productoCarrito->rowId;
        $this->cart = Cart::get($this->rowId);
        Cart::update($this->rowId, $this->cart->qty+1);
    }
}
