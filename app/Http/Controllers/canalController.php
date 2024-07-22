<?php

namespace App\Http\Controllers;

use App\Models\Canal;
use App\Models\Datos;
use App\Models\DatosPromedio;
use App\Models\Dispositivos;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class canalController extends Controller
{

    public function store(Request $request)
    {
        $token_conexion = Str::random(20);

        $canales = Canal::all();

        foreach ($canales as $item) {
            while ($item->token_conexion == $token_conexion) {
                $token_conexion = Str::random(20);
            }
        }

        $canal = Canal::create([
            'nombre_canal' => $request->nombre_canal,
            'lugar' => $request->lugar,
            'tipo' => $request->tipo,
            'token_conexion' => $token_conexion,
            'id_user' => $request->id_user,
        ]);

        return back();
    }

    public function canal($icanal, Request $request, $idDispositivo = null)
    {
        $canal = Canal::where(['id' => $icanal])->first();
        $url = $request->url();
        $dispositivos = Dispositivos::where('id_canal', $icanal)->get();

        if ($idDispositivo != "" && $idDispositivo != null) {
            $dis = DB::table('dispositivos')->where('id', $idDispositivo)->first();
            $datosPromedio = DatosPromedio::where('data_id_canal', $icanal)->with('dispositivo')->get();
            return view('panel.canal.canal', compact('canal', 'dispositivos', 'url', 'dis', 'idDispositivo','datosPromedio'));
        } else {
            $dis = null;

            $datosPromedio = DatosPromedio::where('data_id_canal', $icanal)->with('dispositivo')->get();


            return view('panel.canal.canal', compact('canal', 'dispositivos', 'url', 'dis', 'datosPromedio'));
        }
    }

    public function mis_canales($id)
    {
        $canales = Canal::where('id_user', $id)->get();
        return view('panel.canal.mis-canales', compact('canales'));
    }

    public function edit($id)
    {
        $canal = Canal::find($id);
        return view('panel.canal.edit', compact('canal'));
    }

    public function eliminarCanal($id)
    {

        $dispositivos = DB::table('dispositivos')->where('id_canal', $id)->get();

        foreach ($dispositivos as $dis) {
            $datos = DB::table('datos')->where('nombre_conexion', $dis->nombre_conexion)->get();
            foreach ($datos as $dato) {
                DB::table('datos')->where('nombre_conexion', $dato->nombre_conexion)->delete();
            }
            DB::table('datos')->where('nombre_conexion', $dis->nombre_conexion)->delete();
        }

        $canal = DB::table('canal')
            ->where('id', $id)
            ->delete();
        return back()->with('success', 'Información actualizada');
    }

    public function updateCanal(Request $request, $id)
    {
        $canal = DB::table('canal')
            ->where('id', $id)
            ->update([
                'nombre_canal' => $request->nombre_canal,
                'descripcion' => $request->descripcion,
                'lugar' => $request->lugar,
                'tasa_de_refresco' => $request->tasa_de_refresco
            ]);
        return back()->with('success', 'Información actualizada');
    }

    public function add_dispositivo(Request $request)
    {
        $canal = Canal::where('id', $request->id_canal)->first();
        if ($canal) {
            $dispositivos = Dispositivos::where(['id_canal' => $request->id_canal])->get();

            if ($dispositivos->count() <= 10) {
                $dispositivo = Dispositivos::create([
                    'dispositivo' => $request->dispositivo,
                    'nombre_conexion' => $canal->token_conexion . "campo" . $dispositivos->count() + 1,
                    'estado' => $request->estado,
                    'tipo_grafico' => $request->tipo_grafico,
                    'label_grafico' => $request->label_grafico,
                    'min_grafico' => $request->min_grafico,
                    'max_grafico' => $request->max_grafico,
                    'id_canal' => $request->id_canal,
                ]);
            }
        }

        return back();
    }

    public function updateDispositivo(Request $request, $id, $icanal)
    {
        $dispositivo = DB::table('dispositivos')
            ->where('id', $id)
            ->update([
                'dispositivo' => $request->dispositivo,
                'estado' => $request->estado,
                'tipo_grafico' => $request->tipo_grafico,
                'label_grafico' => $request->label_grafico,
                'min_grafico' => $request->min_grafico == "" ? 0 : $request->min_grafico,
                'max_grafico' => $request->max_grafico == "" ? 100 : $request->max_grafico,
            ]);
        return redirect('/panel/mis-canales/canal/' . $icanal);
    }

    public function deleteDispositivo($id)
    {
        $dispositivo = DB::table('dispositivos')->where('id', $id)->delete();
        return back()->with('success', 'Registro eliminado');
    }

    public function registroDatos(Request $request)
    {
        $key = $request->input('key');
        $campos = [];

        for ($i = 1; $i <= 10; $i++) {
            $campos["campo$i"] = $request->input($key . "campo$i");
        }

        $canal = Canal::where('token_conexion', $key)->first();

        if ($canal) {
            foreach ($campos as $campo => $valor) {
                if ($valor) {
                    $nombre_conexion = $key . $campo;

                    // Crear registro en Datos
                    Datos::create([
                        'nombre_conexion' => $nombre_conexion,
                        'valor' => $valor,
                    ]);

                    // Actualizar o crear registro en DatosPromedio
                    $consulta_datos_promedio_dispositivo = DB::table('datos_promedio')
                        ->where('nombre_conexion', $nombre_conexion)
                        ->first();

                    if ($consulta_datos_promedio_dispositivo) {
                        DB::table('datos_promedio')
                            ->where('nombre_conexion', $nombre_conexion)
                            ->update([
                                'valor' => $valor
                            ]);
                    } else {
                        DatosPromedio::create([
                            'nombre_conexion' => $nombre_conexion,
                            'valor' => $valor,
                            'data_id_canal' => $canal->id
                        ]);
                    }
                }
            }
        }
    }

    public function getDatos($icanal){
        $dispositivos = Dispositivos::where('id_canal', $icanal)->with('datos')->get();
        return response()->json($dispositivos);
    }

    public function getDatosPromedio($icanal){
        $datosPromedio = DatosPromedio::where('data_id_canal', $icanal)->with('dispositivo')->get();
        return response()->json($datosPromedio);
    }

}
