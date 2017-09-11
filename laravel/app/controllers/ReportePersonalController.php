<?php

class ReportePersonalController extends BaseController
{
    protected $_errorController;
    /**
     * Valida sesion activa
     */
    public function __construct(ErrorController $ErrorController)
    {
        $this->beforeFilter('auth');
        $this->_errorController = $ErrorController;
    }
  

  public function postReportepersonal() //Importante que los nombres de los metodos solo deben ser Mayuscula al iniciar!
  {
      //$fecha = Input::get('fecha_ini');
      $fecha = explode('-', Input::get('fecha_ini'));

      $result = file_get_contents("http://www.muniindependencia.gob.pe/spersonal/index.php?mes=".$fecha[1]."&anno=".$fecha[0]);

      return $result;
      /*
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$rst
              //'datos' => array('data' => $rst)
          )
      );
      */

  }

  
}
