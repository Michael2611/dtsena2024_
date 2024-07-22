<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosPromedio extends Model
{
    use HasFactory;

    protected $table = "datos_promedio";

    protected $fillable = [
        'id','data_id_canal','nombre_conexion','valor','created_at'
    ];

    public function dispositivo(){
        return $this->belongsTo(Dispositivos::class, 'nombre_conexion', 'nombre_conexion');
    }

    public function canal(){
        return $this->belongsTo(Canal::class, 'data_id_canal', 'id');
    }

}
