<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Ruta producto
Route::get('/producto/aniadirProducto',[\App\Http\Controllers\ProductoController::class, 'aniadirProducto'])->name('aniadirProducto');
Route::get('/producto/modificarProducto/{id}',[\App\Http\Controllers\ProductoController::class, 'modificarProducto'])->name('modificarProducto');
Route::post('/producto/store',[\App\Http\Controllers\ProductoController::class, 'store'])->name('producto.store');
Route::get('/producto/destroy/{id}',[\App\Http\Controllers\ProductoController::class, 'destroy'])->name('producto.destroy');
Route::get('/producto/destroy/{id}',[\App\Http\Livewire\ProductoController::class, 'destroy'])->name('producto.destroy');
Route::post('/producto/update/{id}',[\App\Http\Controllers\ProductoController::class, 'update'])->name('producto.update');
Route::get('/producto/listarProductos', [\App\Http\Controllers\ProductoController::class, 'listarProductos'])->name('listarProductos');

//Ruta carrito
Route::post('/cart/store',[\App\Http\Controllers\CartController::class,'store'])->name('cart.store');
Route::post('/cart/remove',[\App\Http\Controllers\CartController::class,'remove'])->name('cart.remove');
Route::get('/cart/confirm',[\App\Http\Controllers\CartController::class,'confirm'])->name('cart.confirm');
