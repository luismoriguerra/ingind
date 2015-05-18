<?php

class ErrorController extends \BaseController
{

    /**
     * Valida sesion activa
     */
    public function __construct() 
    {
        $this->beforeFilter('auth');
    }

    public function saveError($exc) 
    {
        $error["code"] = $exc->getCode();
        $error["file"] = $exc->getFile();
        $error["line"] = $exc->getLine();
        $error["message"] = $exc->getMessage();
        $error["trace"] = $exc->getTraceAsString();
        $error["usuario_id"] = Auth::user()->id;
        $error["date"] = date("Y-m-d H:i:s");
        
        DB::table('errores')->insert(
            array($error)
        );
    }
    
    public function saveCustomError($custom)
    {
        DB::table('errores')->insert(
            array($custom)
        );
    }

}
