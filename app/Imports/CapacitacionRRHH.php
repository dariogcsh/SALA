<?php

namespace App\Imports;

use App\capacitacion;
use App\capacitacion_user;
use App\calendario;
use App\calendario_user;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Services\NotificationsService;

class CapacitacionRRHH implements ToCollection, WithChunkReading
{
    protected $notificationsService;
    
    public function __construct(NotificationsService $notificationsService)
    {
        $this->notificationsService = $notificationsService;
    }

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
                'horas' => $row[10],
                'costo' => $row[11],
            ];
       
                $newRecord = Capacitacion::create(end($data));
                // Arraay para insertar en tabla capacitacion_user
                $otraData[] = [
                    'id_capacitacion' => $newRecord->id, // ID del registro en la primera tabla
                    'id_user' => $row[9], // Ajusta según la columna correspondiente
                    'tipo' => 'Participante',
                    'estado' => 'Inscripto',
                ];

                $modalidad = $row[6];
                    if ($modalidad == "WBT") {
                        $tipo_evento = '3';
                    }elseif($modalidad == "DLC"){
                        $tipo_evento = '3';
                    }elseif($modalidad == "Presencial"){
                        $tipo_evento = '4';
                    }else{
                        $tipo_evento = '1';
                    }

                $currentDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]));
                $shippingDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]));
            
                $diferencia_en_dias = $currentDate->diffInDays($shippingDate);
            
                //Genero repetitiva para que inserte en la tabla calendario dia por dia de cada capacitacion
                for ($i=0; $i <= $diferencia_en_dias ; $i++) {

                    //Adicioona dia por dia la fecha
                    $finicio = date("Y-m-d",strtotime($currentDate."+ ".$i." days"));
                    $data_calendario[] = [
                        'id_evento' => $tipo_evento, // Mapea las columnas de Excel a atributos del modelo
                        'id_capacitacion' => $newRecord->id, // Recuerda que las filas son arrays
                        'id_user' => auth()->id(),
                        'ubicacion' => $row[7],
                        'fechainicio' => $finicio,
                        'fechafin' => $finicio,
                        'horainicio' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4])),
                        'horafin' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5])),
                        'titulo' => $row[0],
                    ];

                    $newRecord_calendario = Calendario::create(end($data_calendario));

                    $otraData_calendario[] = [
                        'id_calendario' => $newRecord_calendario->id, // ID del registro en la primera tabla
                        'id_user' => $row[9], // Ajusta según la columna correspondiente
                        'tipo' => 'Participante',
                        'estado' => 'Inscripto',
                    ];

                    $notificationData = [
                        'title' => 'SALA - Capacitación',
                        'body' => 'Usted ha sido registrado en una capacitaciónde '.$row[0].' para el dia '.$finicio.'',
                        'path' => '/capacitacion',
                    ];
                    $this->notificationsService->sendToUser($row[9], $notificationData);
                }
            }
        

        // Insertar en la segunda tabla
        if (!empty($otraData)) {
            Capacitacion_user::insert($otraData);
        }
        if (!empty($otraData_calendario)) {
            Calendario_user::insert($otraData_calendario);
        }
        // Insertar en lotes
        //Capacitacion::insert($data);
    }
    public function chunkSize(): int
    {
        return 500; // El tamaño del bloque, ajusta según tus necesidades
    }
}
