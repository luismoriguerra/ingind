<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MailEnvioGSCCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'mail:envioalertasgsc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'envia email de alertas de la gerencia de seguridad ciudadana.';

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
        $url='reportef/seguridadciudadanaalertas';
        Auth::loginUsingId(697);
        echo Helpers::ruta($url, 'POST', [] );
        Auth::logout();
    }

}
