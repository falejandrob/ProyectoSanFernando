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
Route::get('/autores', [App\Http\Controllers\HomeController::class, 'autores'])->name('autores');
Route::get('/realizarPedido', [App\Http\Controllers\HomeController::class, 'realizarPedido'])->name('realizarPedido');
Route::get('/misPedidos/{id}',[\App\Http\Controllers\HomeController::class, 'misPedidos'])->name('misPedidos');
Route::get('/imprimirPedido/{id}',[\App\Http\Controllers\HomeController::class, 'downloadPdf'])->name('downloadPdf');
Route::get('/imprimirPedidoProveedores/{id}',[\App\Http\Controllers\HomeController::class, 'downloadProvPdf'])->name('downloadProvPdf');
Route::get('/enviarPedido/{id}',[\App\Http\Controllers\HomeController::class, 'sendMail'])->name('sendMail');
Route::get('/detallesPedido/{id}',[\App\Http\Controllers\HomeController::class, 'detallesPedido'])->name('detallesPedido');
Route::get('/detallesPedido/{id}/{profesor}',[\App\Http\Controllers\HomeController::class, 'detallesPedidoAdmin'])->name('detallesPedidoAdmin');
Route::get('/eliminarPedido/{id}',[\App\Http\Controllers\CartController::class, 'eliminarPedido'])->name('eliminarPedido');
Route::get('/eliminarPedidoProfesor/{id}',[\App\Http\Controllers\CartController::class, 'eliminarPedidoProfesor'])->name('eliminarPedidoProfesor');
Route::get('/repetirPedido/{id}',[\App\Http\Controllers\CartController::class, 'repetirPedido'])->name('repetirPedido');
Route::get('/modificarPedido/{id}',[\App\Http\Controllers\CartController::class, 'modificarPedido'])->name('modificarPedido');
Route::get('/validarPedido/{id}/{nombre}/{apellido}/{email}',[\App\Http\Controllers\HomeController::class, 'validarPedido'])->name('validarPedido');
Route::get('/desvalidarPedido/{id}/{nombre}/{apellido}/{email}',[\App\Http\Controllers\HomeController::class, 'desvalidarPedido'])->name('desvalidarPedido');

Route::get('/seleccionarProveedores/{id}',[\App\Http\Controllers\HomeController::class, 'seleccionarProveedores'])->name('seleccionarProveedores');
Route::post('/establecerProveedor',[\App\Http\Controllers\HomeController::class, 'establecerProveedor'])->name('establecerProveedor');
Route::get('/quitarRelacion/{id}',[\App\Http\Controllers\HomeController::class, 'quitarRelacion'])->name('quitarRelacion');

Route::get('/fechaPedidos/',[\App\Http\Controllers\FechaController::class, 'index'])->name('fechaPedidos');
Route::post('/fecha/store',[\App\Http\Controllers\FechaController::class, 'store'])->name('fecha.store');
Route::get('/fecha/modificarFecha/{id}',[\App\Http\Controllers\FechaController::class, 'updateDate'])->name('updateDate');
Route::post('/fecha/update/{id}',[\App\Http\Controllers\FechaController::class, 'update'])->name('fecha.update');
Route::get('/fecha/listarPlazos', [\App\Http\Controllers\FechaController::class, 'listDates'])->name('listDates');

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
Route::post('/cart/confirm',[\App\Http\Controllers\CartController::class,'confirm'])->name('cart.confirm');
Route::post('/cart/modify/{id}',[\App\Http\Controllers\CartController::class,'modify'])->name('cart.modify');

//Ruta pedidos
Route::get('/totalPedidos', [\App\Http\Controllers\HomeController::class, 'totalPedidos'])->name('totalPedidos');
Route::get('/papeleraPedidos', [\App\Http\Controllers\HomeController::class, 'papeleraPedidos'])->name('papeleraPedidos');
Route::get('/restaurarPedido/{id}', [\App\Http\Controllers\HomeController::class, 'restaurarPedido'])->name('restaurarPedido');
Route::get('/papeleraPedidosProfesor/{id}', [\App\Http\Controllers\HomeController::class, 'papeleraPedidosProfesor'])->name('papeleraPedidosProfesor');
Route::get('/restaurarPedidoProfesor/{id}', [\App\Http\Controllers\HomeController::class, 'restaurarPedidoProfesor'])->name('restaurarPedidoProfesor');

Route::get('/addJustificacion',[\App\Http\Controllers\HomeController::class, 'addJustificacion'])->name('addJustificacion');

// Perfil
Route::get('/perfil/{id}',[\App\Http\Controllers\PerfilController::class, 'perfil'])->name('perfil');
Route::post('/perfil/cambiarDatos/{id}',[\App\Http\Controllers\PerfilController::class, 'cambiarDatos'])->name('perfil.cambiarDatos');
Route::post('/perfil/cambiarPass/{id}',[\App\Http\Controllers\PerfilController::class, 'cambiarPass'])->name('perfil.cambiarPass');

// Informes
Route::get('/informes',[\App\Http\Controllers\InformesController::class, 'informes'])->name('informes');
Route::get('/informesProfesor',[\App\Http\Controllers\InformesController::class, 'informesProfesor'])->name('informesProfesor');
Route::post('/informesProfesorResultado',[\App\Http\Controllers\InformesController::class, 'informesProfesorResultado'])->name('informesProfesorResultado');
Route::get('/informesMes',[\App\Http\Controllers\InformesController::class, 'informesMes'])->name('informesMes');
Route::post('/informesMesResultado',[\App\Http\Controllers\InformesController::class, 'informesMesResultado'])->name('informesMesResultado');
