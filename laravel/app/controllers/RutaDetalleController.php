<?php
class RutaDetalleController extends \BaseController
{

    public function postCargarrd()
    {
        if ( Request::ajax() ) {
            $r           = new RutaDetalle;
            $res         = Array();
            $res         = $r->getRutadetalle();

            return Response::json(
                array(
                    'rst'   => '1',
                    'msj'   => 'Detalle Cargado',
                    'datos' => $res
                )
            );
        }
    }

    public function postCargardetalle()
    {
        $r          = new RutaDetalle;
        $res        = Array();
        $res        = $r->getRutadetalle();

        if ( Request::ajax() ) {
            return Response::json(
                array(
                    'rst'=>'1',
                    'msj'=>'Detalle cargado',
                    'datos'=>$res
                )
            );
        }
    }

}
