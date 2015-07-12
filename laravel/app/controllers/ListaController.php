<?php
class ListaController extends \BaseController
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
    /**
     * retornar los tipos de visualizacion
     * POST /lista/tipovisualizacion
     *
     * @return Response
     */
    public function postTipovizualizacion()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {

            $tipos = TipoVisualizacion::getTipo(Input::all());
            return Response::json(array('rst'=>1,'datos'=>$tipos));
        }
    }
}