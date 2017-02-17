<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MailEnvioAlertasCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mail:envioalertas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'envia email de alertas.';

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
        $url='reportef/bandejatramiteenvioalertas';
        Auth::loginUsingId(697);
        echo Helpers::ruta($url, 'POST', [] );
        $url2='envioautomatico/notidocplataformaalertas';
        echo Helpers::ruta($url2, 'POST', [] );
        Auth::logout();
    }

}
