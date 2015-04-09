<?php
class RutaFlujoController extends \BaseController
{

    public function postCrear()
    {
        if ( Request::ajax() ) {
            $r           = new Ruta();
            $res         = Array();
            $res         = $r->crearRuta();

            return Response::json(
                array(
                    'rst'   => $res['rst'],
                    'msj'   => $res['msj'],
                    'ruta_flujo_id'=>$rutaFlujo->id
                )
            );
        }
    }

}
