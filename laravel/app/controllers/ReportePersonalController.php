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

    public function postReportepersonal()
    {
        $fecha = explode('-', Input::get('fecha_ini'));

        $result = file_get_contents("http://www.muniindependencia.gob.pe/spersonal/index.php?mes=".$fecha[1]."&anno=".$fecha[0]);

        return utf8_encode($result);
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

    public function postReportepersonaladm()
    {
        try 
        {
            $fecha_ini = Input::get('fecha_ini');
            $fecha_fin = Input::get('fecha_fin');

            $result = file_get_contents("http://www.muniindependencia.gob.pe/spersonal/consulta.php?inicio=".$fecha_ini."&fin=".$fecha_fin);
            
            return utf8_encode($result);
        }
        catch (\Exception $e) 
        {
            return Response::json(
                        array(
                            'rst'=>2,
                            'reporte'=> 'not_data'
                        )
                    );
        }
    }

}
