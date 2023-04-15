<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use App\Models\Producto;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $productos = Producto::all();
        $anio_actual = Carbon::now()->year;
        $presupuesto = Presupuesto::where('idUser', Auth::id())->where('anio', $anio_actual)->first();


        return view('home', ["productos" => $productos,"presupuesto" =>$presupuesto]);
    }
}
