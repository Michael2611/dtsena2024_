<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datos extends Model
{
    use HasFactory;

    protected $table = "datos";

    protected $fillable = [
        'id',
        'campo1',
        'campo2',
        'campo3',
        'campo4',
        'campo5',
        'campo6',
        'campo7',
        'campo8',
        'campo9',
        'campo10',
        'd_id_canal',
        'created_at'
    ];

    public function dispositivo(){
        return $this->belongsTo(Dispositivos::class, 'id_canal', 'id');
    }

}
