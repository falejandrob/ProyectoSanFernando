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

        $date = Carbon::parse($request->fechaMaxima)->format("Y-m-d");
        //dd($date);
        $time = Carbon::parse($request->horaMaxima)->format('H:i:s');
        //dd($time);
        //$combinedDateTime = $date->copy()->setTime($time->hour, $time->minute, $time->second);
        $finalDate= Carbon::parse($date.$time)->format("Y-m-d H:i:s");
        //dd($finalDate);
        $fecha = FechaMaximaPedido::create([
            'fechaMaxima' => $finalDate,
            'fechaVencida' => 0
        ]);

        $fecha->save();
        return redirect()->action([FechaController::class, 'index']);
    }
}
