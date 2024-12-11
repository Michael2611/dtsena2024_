<?php

namespace App\Http\Controllers;

use App\Models\SurcoPlanta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurcoPlantaController extends Controller
{
    public function generarTablaCultivo(Request $request)
    {
        $request->validate([
            'num_surcos' => 'required|integer|min:1',
            'num_plantas' => 'required|integer|min:1',
            'nomenclatura' => 'required|in:letras,numeros',
        ]);

        $canal = $request->input('canal');
        $num_surcos = $request->input('num_surcos');
        $num_plantas = $request->input('num_plantas');
        $nomenclatura = $request->input('nomenclatura');

        $tabla = [];

        // Generar la nomenclatura para los surcos
        if ($nomenclatura == 'letras') {
            $surcos = range('A', 'Z');  // Surcos con letras
        } else {
            $surcos = range(1, $num_surcos);  // Surcos con números
        }

        // Limitar la cantidad de surcos si es mayor que la cantidad que el usuario indicó
        $surcos = array_slice($surcos, 0, $num_surcos);

        // Crear la tabla con las plantas
        for ($i = 0; $i < $num_plantas; $i++) {
            $fila = [];
            foreach ($surcos as $surco) {
                $fila[] = ['surco' => $surco, 'planta' => 'Planta ' . ($i + 1)];
            }
            $tabla[] = $fila;
        }

        $especies = implode(',', $request->input('especies'));

        // Guardar en la base de datos
        $tabla_guardada = SurcoPlanta::create([
            'canal' => $canal,
            'nomenclatura' => $nomenclatura,
            'num_surcos' => $num_surcos,
            'num_plantas' => $num_plantas,
            'tabla' => json_encode($tabla), // Convertir a JSON
            'especies' => $especies,
        ]);

        return back();
    }

    public function actualizarTablaCultivo(Request $request)
    {
        $request->validate([
            'num_surcos' => 'required|integer|min:1',
            'num_plantas' => 'required|integer|min:1',
            'nomenclatura' => 'required|in:letras,numeros',
        ]);

        $canal = $request->input('canal');
        $num_surcos = $request->input('num_surcos');
        $num_plantas = $request->input('num_plantas');
        $nomenclatura = $request->input('nomenclatura');

        $especies = implode(',', $request->input('especies'));

        $tabla = [];

        // Generar la nomenclatura para los surcos
        if ($nomenclatura == 'letras') {
            $surcos = range('A', 'Z');  // Surcos con letras
        } else {
            $surcos = range(1, $num_surcos);  // Surcos con números
        }

        // Limitar la cantidad de surcos si es mayor que la cantidad que el usuario indicó
        $surcos = array_slice($surcos, 0, $num_surcos);

        // Crear la tabla con las plantas
        for ($i = 0; $i < $num_plantas; $i++) {
            $fila = [];
            foreach ($surcos as $surco) {
                $fila[] = ['surco' => $surco, 'planta' => 'Planta ' . ($i + 1)];
            }
            $tabla[] = $fila;
        }

        // Guardar en la base de datos
        DB::table('surcos_plantas')
        ->where('canal', $canal)
        ->update([
            'num_surcos' => $num_surcos,
            'num_plantas' => $num_plantas,
            'nomenclatura' => $nomenclatura,
            'tabla' => json_encode($tabla), // Convertir a JSON
            'especies' => $especies
        ]);

        return back();
    }

}
