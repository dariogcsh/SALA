<?php

namespace App\Imports;

use App\cosecha;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class MiImportador implements ToCollection, WithChunkReading
{
    public function collection(Collection $rows)
    {
        $data = [];

        foreach ($rows as $row) {
            $data[] = [
            'cliente' => $row[0], // Mapea las columnas de Excel a atributos del modelo
            'granja' => $row[1], // Recuerda que las filas son arrays
            'organizacion' => $row[2],
            'campo' => $row[3],
            'nombre_maquina' => $row[4],
            'pin' => $row[5],
            'operador' => $row[6],
            'variedad' => $row[7],
            'cultivo' => $row[8],
            'superficie' => $row[9],
            'humedad' => $row[10],
            'rendimiento' => $row[11],
            'combustible' => $row[12],
            'inicio' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[13])),
            'fin' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[14])),
            ];
        }
        // Insertar en lotes
        Cosecha::insert($data);
    }
    public function chunkSize(): int
    {
        return 500; // El tamaño del bloque, ajusta según tus necesidades
    }
}
