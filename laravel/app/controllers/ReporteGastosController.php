<?php

class ReporteGastosController extends BaseController
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
  

  public function postReportedetallegastos() //Importante que los nombres de los metodos solo deben ser Mayuscula al iniciar!
  {
      $rst = GastosDetallesContables::ReporteDetalleGastos();
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$rst
              //'datos' => array('data' => $rst)
          )
      );
  }

  public function postReportedetallegastostotales()
  {
      $rst = GastosDetallesContables::ReporteDetalleGastosTotales();
      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$rst
          )
      );
  }
        
    
}
