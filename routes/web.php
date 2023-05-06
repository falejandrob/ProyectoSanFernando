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
Route::get('/misPedidos/{id}',[\App\Http\Controllers\HomeController::class, 'misPedidos'])->name('misPedidos');
Route::get('/detallesPedido/{id}',[\App\Http\Controllers\HomeController::class, 'detallesPedido'])->name('detallesPedido');
Route::get('/eliminarPedido/{id}',[\App\Http\Controllers\CartController::class, 'eliminarPedido'])->name('eliminarPedido');
Route::get('/repetirPedido/{id}',[\App\Http\Controllers\CartController::class, 'repetirPedido'])->name('repetirPedido');

//Ruta producto
Route::get('/producto/aniadirProducto',[\App\Http\Controllers\ProductoController::class, 'aniadirProducto'])->name('aniadirProducto');
Route::get('/producto/modificarProducto/{id}',[\App\Http\Controllers\ProductoController::class, 'modificarProducto'])->name('modificarProducto');
Route::post('/producto/store',[\App\Http\Controllers\ProductoController::class, 'store'])->name('producto.store');
Route::get('/producto/destroy/{id}',[\App\Http\Controllers\ProductoController::class, 'destroy'])->name('producto.destroy');
Route::post('/producto/update/{id}',[\App\Http\Controllers\ProductoController::class, 'update'])->name('producto.update');
Route::get('/producto/listarProductos', [\App\Http\Controllers\ProductoController::class, 'listarProductos'])->name('listarProductos');

//Ruta profesores
Route::get('/profesor/listarProfesores', [\App\Http\Controllers\ProfesorController::class, 'listarProfesores'])->name('listarProfesores');
Route::get('/profesor/modificarProfesor/{id}',[\App\Http\Controllers\ProfesorController::class, 'modificarProfesor'])->name('modificarProfesor');
Route::post('/profesor/update/{id}',[\App\Http\Controllers\ProfesorController::class, 'update'])->name('profesor.update');
Route::get('/profesor/cambiarPassword/{id}',[\App\Http\Controllers\ProfesorController::class, 'cambiarPassword'])->name('cambiarPassword');
Route::post('/profesor/pass/{id}',[\App\Http\Controllers\ProfesorController::class, 'pass'])->name('profesor.pass');

//Ruta proveedores
Route::get('/proveedor/aniadirProveedor',[\App\Http\Controllers\ProveedorController::class, 'aniadirProveedor'])->name('aniadirProveedor');
Route::post('/proveedor/store',[\App\Http\Controllers\ProveedorController::class, 'store'])->name('proveedor.store');
Route::get('/proveedor/listarProveedores', [\App\Http\Controllers\ProveedorController::class, 'listarProveedores'])->name('listarProveedores');
Route::get('/proveedor/modificarProveedores/{id}',[\App\Http\Controllers\ProveedorController::class, 'modificarProveedor'])->name('modificarProveedor');
Route::post('/proveedor/update/{id}',[\App\Http\Controllers\ProveedorController::class, 'update'])->name('proveedor.update');

//Ruta carrito
Route::post('/cart/store',[\App\Http\Controllers\CartController::class,'store'])->name('cart.store');
Route::post('/cart/remove',[\App\Http\Controllers\CartController::class,'remove'])->name('cart.remove');
Route::get('/cart/confirm',[\App\Http\Controllers\CartController::class,'confirm'])->name('cart.confirm');

//Ruta pedidos
Route::get('/totalPedidos', [\App\Http\Controllers\HomeController::class, 'totalPedidos'])->name('totalPedidos');

Route::get('/addJustificacion',[\App\Http\Controllers\HomeController::class, 'addJustificacion'])->name('addJustificacion');
