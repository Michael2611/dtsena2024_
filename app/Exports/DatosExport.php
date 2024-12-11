<?php

namespace App\Exports;

use App\Models\Datos;
use Maatwebsite\Excel\Concerns\FromCollection;

class DatosExport implements FromCollection
{

    protected $datos_Id;

    public function __construct($datos_Id)
    {
        $this->datos_Id = $datos_Id;
    }

    public function collection()
    {
        $datos = Datos::where('d_id_canal', $this->datos_Id)->get();

        // Filtrar columnas nulas
        $datosFiltrados = $datos->map(function ($item) {
            return collect($item)->filter(function ($value, $key) {
                return !is_null($value);
            });
        });

        return $datosFiltrados;
    }

    public function headings(): array
    {
        // Obtener las cabeceras sin las columnas nulas
        $datos = Datos::where('d_id_canal', $this->datos_Id)->first();

        if ($datos) {
            $filteredHeaders = collect($datos)->filter(function ($value, $key) {
                return !is_null($value);
            })->keys()->toArray();

            return $filteredHeaders;
        }

        return [
            'id',
            'campo1',
            'campo2',
            'fecha de registro',
        ];
    }

}
