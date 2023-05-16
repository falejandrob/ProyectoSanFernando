<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FechaMaximaPedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'fechaMinima',
        'fechaMaxima',
        'fechaVencida',
    ];

    public function scopeClosestToDate($query)
    {
        $currentDate = Carbon::now()->toDateString();

        return $query->orderByRaw('ABS(DATEDIFF(fechaMaxima, ?))', [$currentDate]);
    }
}
