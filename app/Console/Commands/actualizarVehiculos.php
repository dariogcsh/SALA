<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationsService;
use Carbon\Carbon;
use App\vehiculo;

class actualizarVehiculos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'actualizar:vehiculos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tarea Cron para actualizar el listado de vehículos desde la API de VSat';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(NotificationsService $notificationsService)
    {
        $this->notificationsService = $notificationsService;
        $ayer = Carbon::yesterday();
        $fecha = $ayer->subMonth(3);
        $token = "hii35C5UPX5lvdV%2bqHExQZa%2fbb9WywBy3K3dz6lxWosDaDv2voyrzwSlsBWu40l%2f";
        $apiEndpoint = "https://vsateq.com.ar/comGpsGate/api/v.1/applications/355/users?FromIndex=0&PageSize=1000&ViewId=525";

        $cont = 0;
        $reg[]="";
        $r = 0;
        $vehiculos_reg = Vehiculo::orderBy('id','desc')->get();
        foreach($vehiculos_reg as $vehiculo_reg){
            $registro[$r] = $vehiculo_reg->id_vsat;
            $r++;
        }

       for ($i=0; $i < 300 ; $i++) { 
            try {
                $ch = curl_init($apiEndpoint);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Authorization:". $token,
                ));

                $response = curl_exec($ch);
                curl_close($ch);

                $decodedResponse = json_decode($response, true);
                
                $prueba = $decodedResponse[$i]["deviceActivity"];  

                if ($prueba > $fecha) {
                    $nombre[$cont] = $decodedResponse[$i]["name"];
                    $id[$cont] = $decodedResponse[$i]["id"];
                    if (isset($registro)) {
                        if(!in_array($id[$cont], $registro)){
                            $vehiculo = Vehiculo::create(['id_vsat'=>$id[$cont], 'nombre'=>$nombre[$cont]]);
                        } else{
                            $vehiculo = Vehiculo::where('id_vsat', $id[$cont])->first();
                            $vehiculo->update(['nombre' => $nombre[$cont]]);
                        }
                    } else {
                        $vehiculo = Vehiculo::create(['id_vsat'=>$id[$cont], 'nombre'=>$nombre[$cont]]);
                    }
                    
                    $cont++;
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        //Envio de notificacion
        $notificationData = [
            'title' => 'SALA - Tarea Cron',
            'body' => 'Se ha actualizado el listado de vehículos en la App de SALA por medio de la API de VSat',
            'path' => '/home',
        ];
        $this->notificationsService->sendToUser('3', $notificationData);
    }
}
