<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\maq_location;

class deleteUbicaciones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:ubicaciones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para vaciar la tabla de ubicaciones diariamente.';

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
        Maq_location::truncate();
    }
}
