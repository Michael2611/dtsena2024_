<?php

namespace App\Http\Controllers;

use App\Exports\DatosExport;
use App\Models\Canal;
use App\Models\Datos;
use App\Models\DatosPromedio;
use App\Models\Dispositivos;
use App\Models\SurcoPlanta;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

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
            return view('vistas-canal.vista_publica', compact('canal', 'dispositivos', 'url', 'dis', 'idDispositivo', 'datosPromedio'));
        } else {
            $dis = null;
            $datosPromedio = DatosPromedio::where('data_id_canal', $icanal)->with('dispositivo')->get();
            return view('vistas-canal.vista_publica', compact('canal', 'dispositivos', 'url', 'dis', 'datosPromedio'));
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
                    'nombre_conexion' => "campo" . $dispositivos->count() + 1,
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
        $campos = $request->only(['campo1', 'campo2', 'campo3', 'campo4', 'campo5', 'campo6', 'campo7', 'campo8', 'campo9', 'campo10']);

        $canal = Canal::where('token_conexion', $key)->first();

        if ($canal) {
            Datos::create([
                'campo1' => $campos['campo1'] ?? null,
                'campo2' => $campos['campo2'] ?? null,
                'campo3' => $campos['campo3'] ?? null,
                'campo4' => $campos['campo4'] ?? null,
                'campo5' => $campos['campo5'] ?? null,
                'campo6' => $campos['campo6'] ?? null,
                'campo7' => $campos['campo7'] ?? null,
                'campo8' => $campos['campo8'] ?? null,
                'campo9' => $campos['campo9'] ?? null,
                'campo10' => $campos['campo10'] ?? null,
                'd_id_canal' => $canal->id
            ]);

            // Actualizar o crear registro en DatosPromedio
            /*$consulta_datos_promedio_dispositivo = DB::table('datos_promedio')
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
            }*/
        }


        /*$canal = Canal::where('token_conexion', $key)->first();

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
        }*/
    }

    public function getDatos($icanal)
    {
        $dispositivos = Dispositivos::where('id_canal', $icanal)->with('datos')->get();
        return response()->json($dispositivos);
    }

    public function getDatosPromedio($icanal)
    {
        $datosPromedio = DatosPromedio::where('data_id_canal', $icanal)->with('dispositivo')->get();
        return response()->json($datosPromedio);
    }

    public function exportarExcelDatos($id)
    {
        return Excel::download(new DatosExport($id), 'datos.xlsx');
    }


    //nuevas rutas
    public function configuracion_canal($id, Request $request, $idDispositivo = null)
    {
        $canal = Canal::where(['id' => $id])->first();
        $url = $request->url();
        $dispositivos = Dispositivos::where('id_canal', $id)->get();

        if ($idDispositivo != "" && $idDispositivo != null) {
            $dis = DB::table('dispositivos')->where('id', $idDispositivo)->first();
            $datosPromedio = DatosPromedio::where('data_id_canal', $id)->with('dispositivo')->get();
            return view('vistas-canal.configuracion_canal', compact('canal', 'dispositivos', 'idDispositivo', 'datosPromedio'));
        } else {
            $dis = null;
            $datosPromedio = DatosPromedio::where('data_id_canal', $id)->with('dispositivo')->get();
            return view('vistas-canal.configuracion_canal', compact('canal', 'dispositivos', 'url', 'dis', 'datosPromedio'));
        }
    }

    public function vista_dispositivos($id, Request $request, $idDispositivo = null)
    {
        $canal = Canal::where(['id' => $id])->first();
        $url = $request->url();
        $dispositivos = Dispositivos::where('id_canal', $id)->get();

        if ($idDispositivo != "" && $idDispositivo != null) {
            $dis = DB::table('dispositivos')->where('id', $idDispositivo)->first();
            $datosPromedio = DatosPromedio::where('data_id_canal', $id)->with('dispositivo')->get();
            return view('vistas-canal.dispositivos', compact('canal', 'dispositivos', 'idDispositivo', 'datosPromedio'));
        } else {
            $dis = null;
            $datosPromedio = DatosPromedio::where('data_id_canal', $id)->with('dispositivo')->get();
            return view('vistas-canal.dispositivos', compact('canal', 'dispositivos', 'url', 'dis', 'datosPromedio'));
        }
    }

    public function vista_publica($id, Request $request, $idDispositivo = null)
    {
        $canal = Canal::where(['id' => $id])->first();
        $url = $request->url();
        $dispositivos = Dispositivos::where('id_canal', $id)->get();

        if ($idDispositivo != "" && $idDispositivo != null) {
            $dis = DB::table('dispositivos')->where('id', $idDispositivo)->first();
            $datosPromedio = DatosPromedio::where('data_id_canal', $id)->with('dispositivo')->get();
            return view('vistas-canal.vista_publica', compact('canal', 'dispositivos', 'idDispositivo', 'datosPromedio'));
        } else {
            $dis = null;
            $datosPromedio = DatosPromedio::where('data_id_canal', $id)->with('dispositivo')->get();
            return view('vistas-canal.vista_publica', compact('canal', 'dispositivos', 'url', 'dis', 'datosPromedio'));
        }
    }

    public function compartir($id, Request $request, $idDispositivo = null)
    {
        $canal = Canal::where(['id' => $id])->first();
        $url = $request->url();
        $dispositivos = Dispositivos::where('id_canal', $id)->get();

        if ($idDispositivo != "" && $idDispositivo != null) {
            $dis = DB::table('dispositivos')->where('id', $idDispositivo)->first();
            $datosPromedio = DatosPromedio::where('data_id_canal', $id)->with('dispositivo')->get();
            return view('vistas-canal.compartir', compact('canal', 'dispositivos', 'idDispositivo', 'datosPromedio'));
        } else {
            $dis = null;
            $datosPromedio = DatosPromedio::where('data_id_canal', $id)->with('dispositivo')->get();
            return view('vistas-canal.compartir', compact('canal', 'dispositivos', 'url', 'dis', 'datosPromedio'));
        }
    }

    public function credenciales($id, Request $request, $idDispositivo = null)
    {
        $canal = Canal::where(['id' => $id])->first();
        $url = $request->url();
        $dispositivos = Dispositivos::where('id_canal', $id)->get();

        if ($idDispositivo != "" && $idDispositivo != null) {
            $dis = DB::table('dispositivos')->where('id', $idDispositivo)->first();
            $datosPromedio = DatosPromedio::where('data_id_canal', $id)->with('dispositivo')->get();
            return view('vistas-canal.credenciales', compact('canal', 'dispositivos', 'idDispositivo', 'datosPromedio'));
        } else {
            $dis = null;
            $datosPromedio = DatosPromedio::where('data_id_canal', $id)->with('dispositivo')->get();
            return view('vistas-canal.credenciales', compact('canal', 'dispositivos', 'url', 'dis', 'datosPromedio'));
        }
    }

    public function distribucion_terreno($id, Request $request, $idDispositivo = null)
    {
        $canal = Canal::where(['id' => $id])->first();
        $url = $request->url();
        $dispositivos = Dispositivos::where('id_canal', $id)->get();

        $registro_canal = SurcoPlanta::where('canal', $id)->first();

        $tabla = [];
        if ($registro_canal) {
            $tabla = json_decode($registro_canal->tabla, true);  // Decodificar el campo 'tabla' de JSON
            if ($tabla === null) {
                // Si la decodificación falla, manejar el error
                return 'Error al decodificar el campo tabla.';
            }
        }

        if ($idDispositivo != "" && $idDispositivo != null) {
            $dis = DB::table('dispositivos')->where('id', $idDispositivo)->first();
            $datosPromedio = DatosPromedio::where('data_id_canal', $id)->with('dispositivo')->get();
            return view('vistas-canal.distribucion_terreno', compact('canal', 'dispositivos', 'idDispositivo', 'datosPromedio', 'registro_canal','tabla'));
        } else {
            $dis = null;
            $datosPromedio = DatosPromedio::where('data_id_canal', $id)->with('dispositivo')->get();
            return view('vistas-canal.distribucion_terreno', compact('canal', 'dispositivos', 'url', 'dis', 'datosPromedio', 'registro_canal','tabla'));
        }
    }
}
