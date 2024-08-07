<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    use HasFactory;

    protected $table = "canal";

    protected $fillable = [
        'id','nombre_canal','lugar','tipo','token_conexion','tasa_de_refresco','id_user'
    ];

    public function datosPromedio(){
        return $this->hasMany(DatosPromedio::class, 'data_id_canal', 'id');
    }

}
