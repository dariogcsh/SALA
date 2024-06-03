<?php

namespace App\Imports;

use App\capacitacion;
use App\capacitacion_user;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class CapacitacionRRHH implements ToCollection, WithChunkReading
{

    private $processedKeys = []; // Propiedad para almacenar las combinaciones únicas procesadas

    public function collection(Collection $rows)
    {
        $data = [];
        $data_colaborador = [];
        foreach ($rows as $row) {
            // Definir una clave única basada en la combinación de cuatro campos
                $uniqueKey = $row[1] . '|' . $row[2] . '|' . $row[3] . '|' . $row[6] . '|' . $row[7];

           // Verificar si la combinación única ya ha sido procesada en esta sesión
           if (in_array($uniqueKey, $this->processedKeys)) {
            continue; // Si ya se procesó, saltarlo
            }

            // Verificar si el registro ya existe en la base de datos con la misma combinación de campos
            $existingRecord = Capacitacion::where([
                ['codigo', $row[1]],
                ['fechainicio', Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]))],
                ['fechafin', Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]))],
                ['modalidad', $row[6]],
                ['ubicacion', $row[7]],
            ])->first();

            if ($existingRecord) {
                continue; // Si ya existe, saltarlo
            }

            // Añadir la combinación única al array de claves procesadas
            $this->processedKeys[] = $uniqueKey;
        
            $data[] = [
                'nombre' => $row[0], // Mapea las columnas de Excel a atributos del modelo
                'codigo' => $row[1], // Recuerda que las filas son arrays
                'fechainicio' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2])),
                'fechafin' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3])),
                'horainicio' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4])),
                'horafin' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])),
                'modalidad' => $row[6],
                'ubicacion' => $row[7],
            ];
       
                $newRecord = Capacitacion::create(end($data));
                // Suponiendo que otra columna relevante está en $row[5]
                $otraData[] = [
                    'id_capacitacion' => $newRecord->id, // ID del registro en la primera tabla
                    'id_user' => $row[9], // Ajusta según la columna correspondiente
                ];
            }
        

        // Insertar en la segunda tabla
        if (!empty($otraData)) {
            Capacitacion_user::insert($otraData);
        }
        // Insertar en lotes
        //Capacitacion::insert($data);
    }
    public function chunkSize(): int
    {
        return 500; // El tamaño del bloque, ajusta según tus necesidades
    }
}
