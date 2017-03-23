<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MailEnvioActividadCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mailact:envioactividad';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'envia email de actividad.';

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
     * @return mixed
     */
    public function fire()
    {
        Auth::loginUsingId(697);
        $url='envioautomatico/actividadesdiariasalertas';
        echo Helpers::ruta($url, 'POST', [] );
        $url2='envioautomatico/actividadesdiariasalertasjefe';
        echo Helpers::ruta($url2, 'POST', [] );
        $url3='envioautomatico/contratacionesalertas';
        echo Helpers::ruta($url3, 'POST', [] );
        Auth::logout();
    }

}
