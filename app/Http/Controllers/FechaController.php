<?php

namespace App\Http\Controllers;

use App\Models\FechaMaximaPedido;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FechaController
{

    public function index()
    {
        $expectedDate = date("Y-m-d");
        $expectedTime = date("H:i");

        return view("admin.fechaLimite", compact('expectedDate', 'expectedTime'));
    }

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
            'fechaMaxima' => $finalFechaMax,
            'fechaVencida' => 0
        ]);

        $fecha->save();
        session()->flash('success', 'El plazo se ha guardado correctamente.');
        return redirect()->action([FechaController::class, 'index']);
    }
}
