<?php

class MensajeDetalleController extends \BaseController
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
     * Changed the specified resource from storage.
     * POST /rol/cambiarestado
     *
     * @return Response
     */
    public function postGuardarvisto()
    {

        if ( Request::ajax() ) {

            $md = new MensajeDetalle;
            $md->mensaje_id = Input::get('mid');
            $md->area_id= Auth::user()->area_id;
            $md->usuario_created_at = Auth::user()->id;
            $md->save();

            return Response::json(array('rst'=>1, 'msj'=>'Registro realizado correctamente'));
  

        }
    }

}
