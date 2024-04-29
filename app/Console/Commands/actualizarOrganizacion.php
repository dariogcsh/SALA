<?php

namespace App\Console\Commands;

use App\organizacion;
use App\maquina;
use App\Services\NotificationsService;
use App\User;
use Illuminate\Console\Command;

class actualizarOrganizacion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'actualizar:organizacion';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para actualizar si la organizacion esta monitoreada o no en la tabla Organizacions';

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
        $organizaciones = Organizacion::all();
        foreach ($organizaciones as $organizacion) {
            $monitoreada = Maquina::where([['InscMaq','SI'], ['CodiOrga',$organizacion->id]])->count();
            if(!empty($monitoreada)){
                if ($monitoreada > 0){
                    $organizacion->update(['InscOrga' => 'SI']);
                }
            } else {
                $organizacion->update(['InscOrga' => 'NO']); 
            }
        }
    }
}