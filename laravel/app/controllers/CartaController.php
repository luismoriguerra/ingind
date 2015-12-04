<?php

class CartaController extends \BaseController
{
    public function __construct()
    {
        $this->beforeFilter('auth');
    }

    public function postCorrelativo()
    {
        if ( Request::ajax() ) {
            $r = Carta::Correlativo();
            return Response::json(array('rst'=>1,'datos'=>$r));
        }
    }

    public function postCargardetalle()
    {
        if ( Request::ajax() ) {
            $r = Carta::CargarDetalle();
            return Response::json(array('rst'=>1,'datos'=>$r));
        }
    }

    public function postGuardar()
    {
        if ( Request::ajax() ) {
            $r=Carta::CrearActualizar();
            return Response::json(
                $r
            );
        }
    }

    public function postCargar()
    {
        if ( Request::ajax() ) {
            $r = Carta::Cargar();
            return Response::json(array('rst'=>1,'datos'=>$r));
        }
    }

}
