<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispositivos extends Model
{
    use HasFactory;

    protected $table = "dispositivos";
    protected $fillable = ['id','estado','dispositivo','nombre_conexion','tipo_grafico','label_grafico','min_grafico','max_grafico','id_canal'];

    public function datos(){
        return $this->hasMany(Datos::class, 'nombre_conexion','nombre_conexion');
    }

    public function datosPromedio(){
        return $this->hasMany(DatosPromedio::class, 'nombre_conexion', 'nombre_conexion');
    }

}
