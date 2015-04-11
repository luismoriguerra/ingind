<?php
class RutaController extends \BaseController
{

    public function postCrear()
    {
        if ( Request::ajax() ) {
            $r           = new Ruta;
            $res         = Array();
            $res         = $r->crearRuta();

            return Response::json(
                array(
                    'rst'   => $res['rst'],
                    'msj'   => $res['msj']
                )
            );
        }
    }

}
