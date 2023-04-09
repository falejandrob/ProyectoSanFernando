<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'validado',
        'idCategoria',
        'foto'

    ];

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            $base64 = base64_encode($this->foto);
            $mime = 'image/jpg'; // Reemplace esto con el tipo MIME correcto de su imagen
            return 'data:' . $mime . ';base64,' . $base64;
        }
        return null;
    }

}
