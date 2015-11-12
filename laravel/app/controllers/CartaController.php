<?php

class CartaController extends \BaseController
{
    public function __construct()
    {
        $this->beforeFilter('auth');
    }

    public function postCargar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $r = Carta::Cargar();
            return Response::json(array('rst'=>1,'datos'=>$r));
        }
    }

    public function postGuardar()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            /*$documento = new Documento;
            $documento['nombre'] = Input::get('nombre');
            $documento['estado'] = Input::get('estado');
            $documento['usuario_created_at'] = Auth::user()->id;
            $documento->save();*/

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro realizado correctamente',
                )
            );
        }
    }
}
