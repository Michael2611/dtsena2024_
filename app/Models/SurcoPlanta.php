<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurcoPlanta extends Model
{
    use HasFactory;

    protected $table = "surcos_plantas";

    protected $fillable = [
        'canal',
        'nomenclatura',
        'num_surcos',
        'num_plantas',
        'tabla',
        'especies',
        'id'
    ];

}
