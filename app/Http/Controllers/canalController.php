<?php

namespace App\Http\Controllers;

use App\Models\Canal;
use App\Models\Datos;
use App\Models\Dispositivos;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class canalController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

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

        if($idDispositivo!="" && $idDispositivo!=null){
            $dis = DB::table('dispositivos')->where('id', $idDispositivo)->first();
            return view('panel.canal.canal', compact('canal', 'dispositivos','url','dis','idDispositivo'));
        }else{
            $dis = null;
            return view('panel.canal.canal', compact('canal', 'dispositivos','url','dis'));
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

        foreach($dispositivos as $dis){
            $datos = DB::table('datos')->where('nombre_conexion', $dis->nombre_conexion)->get();
            foreach($datos as $dato){
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
            ]);
        return back()->with('success', 'Información actualizada');
    }

    public function destroy($id)
    {
        //
    }

    public function add_dispositivo(Request $request)
    {
        $canal = Canal::where('id', $request->id_canal)->first();
        if ($canal) {
            $dispositivos = Dispositivos::where(['id_canal' => $request->id_canal])->get();

            if ($dispositivos->count() <= 10) {
                $dispositivo = Dispositivos::create([
                    'dispositivo' => $request->dispositivo,
                    'nombre_conexion' => $canal->token_conexion."campo".$dispositivos->count()+1,
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
        return redirect('/panel/mis-canales/canal/'.$icanal);
    }

    public function deleteDispositivo($id)
    {
        $dispositivo = DB::table('dispositivos')->where('id', $id)->delete();
        return back()->with('success', 'Registro eliminado');
    }

    public function registroDatos(Request $request)
    {
        $key = $request->input('key');
        $campo1 = $request->input('key')."campo1";
        $campo2 = $request->input('key')."campo2";
        $campo3 = $request->input('key')."campo3";
        $campo4 = $request->input('key')."campo4";
        $campo5 = $request->input('key')."campo5";
        $campo6 = $request->input('key')."campo6";
        $campo7 = $request->input('key')."campo7";
        $campo8 = $request->input('key')."campo8";
        $campo9 = $request->input('key')."campo9";
        $campo10 = $request->input('key')."campo10";

        $canal = Canal::all();
        foreach ($canal as $item) {
            if ($item->token_conexion == $key) {
                if ($campo1) {
                    Datos::create([
                        'nombre_conexion' => $key."campo1",
                        'valor' => $campo1,
                    ]);
                }
                if ($campo2) {
                    Datos::create([
                        'nombre_conexion' => $key."campo2",
                        'valor' => $campo2,
                    ]);
                }
                if ($campo3) {
                    Datos::create([
                        'nombre_conexion' => $key."campo3",
                        'valor' => $campo3,
                    ]);
                }
                if ($campo4) {
                    Datos::create([
                        'nombre_conexion' => $key."campo4",
                        'valor' => $campo4,
                    ]);
                }
                if ($campo5) {
                    Datos::create([
                        'nombre_conexion' => $key."campo5",
                        'valor' => $campo5,
                    ]);
                }
                if ($campo6) {
                    Datos::create([
                        'nombre_conexion' => $key."campo6",
                        'valor' => $campo6,
                    ]);
                }
                if ($campo7) {
                    Datos::create([
                        'nombre_conexion' => $key."campo7",
                        'valor' => $campo7,
                    ]);
                }
                if ($campo8) {
                    Datos::create([
                        'nombre_conexion' => $key."campo8",
                        'valor' => $campo8,
                    ]);
                }
                if ($campo9) {
                    Datos::create([
                        'nombre_conexion' => $item->id,
                        'valor' => $campo9,
                    ]);
                }
                if ($campo10) {
                    Datos::create([
                        'nombre_conexion' => $item->id,
                        'valor' => $campo10,
                    ]);
                }
            }
        }
    }
}
