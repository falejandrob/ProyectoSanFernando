<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\FechaMaximaPedido;
use App\Models\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FechaController
{


    public function index()
    {
        $expectedDate = date("Y-m-d");
        $expectedTime = date("H:i");

        return view("admin.add-date", compact('expectedDate', 'expectedTime'));
    }

    /**
     * Stores the term when you can make an order
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $fechaMaxima = Carbon::parse($request->fechaMaxima)->format("Y-m-d");
        $fechaMinima = Carbon::parse($request->fechaMinima)->format("Y-m-d");
        //dd($date);
        $horaMaxima = Carbon::parse($request->horaMaxima)->format('H:i:s');
        $horaMinima = Carbon::parse($request->horaMinima)->format('H:i:s');
        //dd($time);
        //$combinedDateTime = $date->copy()->setTime($time->hour, $time->minute, $time->second);
        $finalFechaMin= Carbon::parse($fechaMinima.$horaMinima)->format("Y-m-d H:i:s");
        $finalFechaMax= Carbon::parse($fechaMaxima.$horaMaxima)->format("Y-m-d H:i:s");
        //dd($finalDate);
        $fecha = FechaMaximaPedido::create([
            'fechaMinima' => $finalFechaMin,
            'fechaMaxima' => $finalFechaMax
        ]);

        $fecha->save();
        session()->flash('success', 'El plazo se ha guardado correctamente.');
        return redirect()->action([FechaController::class, 'listDates']);
    }

    /**
     * Update the term when you can make an order
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(Request $request, $id)
    {
        $fechaMaxima = Carbon::parse($request->fechaMaxima)->format("Y-m-d");
        $fechaMinima = Carbon::parse($request->fechaMinima)->format("Y-m-d");

        $horaMaxima = Carbon::parse($request->horaMaxima)->format('H:i:s');
        $horaMinima = Carbon::parse($request->horaMinima)->format('H:i:s');

        $finalFechaMin= Carbon::parse($fechaMinima.$horaMinima)->format("Y-m-d H:i:s");
        $finalFechaMax= Carbon::parse($fechaMaxima.$horaMaxima)->format("Y-m-d H:i:s");

        $fecha = FechaMaximaPedido::find($id);
        $fecha->fechaMinima = $finalFechaMin;
        $fecha->fechaMaxima = $finalFechaMax;
        $fecha->save();
        session()->flash('success', 'El plazo se ha modificado correctamente.');
        return redirect()->action([FechaController::class, 'listDates']);
    }

    /**
     * Update an existing term to make an order
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function updateDate($id){

        $date = FechaMaximaPedido::find($id);

        $fechaMaxima = Carbon::parse($date->fechaMaxima)->format("Y-m-d");
        $fechaMinima = Carbon::parse($date->fechaMinima)->format("Y-m-d");

        $horaMaxima = Carbon::parse($date->horaMaxima)->format('H:i');
        $horaMinima = Carbon::parse($date->horaMinima)->format('H:i');

        return view("admin.update-date", compact('date', 'fechaMaxima', 'fechaMinima', 'horaMaxima', 'horaMinima'));
    }



    public function listDates()
    {
        return view('admin.list-date');
    }
}
