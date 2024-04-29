<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\alertasdiaria;

class DeleteAlertas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:alertas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commando para eliminar la tabla auxiliar de las alertas diarias.';

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
    public function handle()
    {
        Alertasdiaria::truncate();
    }
}
