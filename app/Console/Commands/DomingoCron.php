<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DomingoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:domingos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'pasamos de domingo a lunes';

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
        try{
                $servicio = new pasarDia();
                $response = $servicio->sumarDia();
                $this->info('Se realizo correctamente');
        }catch(\Exception $e){
            $this->info('Ocurrio un error');
        }
    }
}
