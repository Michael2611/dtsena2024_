<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datos extends Model
{
    use HasFactory;

    protected $table = "datos";

    protected $fillable = [
        'id','nombre_conexion','valor','fecha_registro'
    ];

    public function dispositivo(){
        return $this->belongsTo(Dispositivos::class, 'nombre_conexion', 'id');
    }

}
