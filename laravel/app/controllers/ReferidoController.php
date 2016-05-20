<?php
class ReferidoController extends \BaseController
{

    public function postExpediente(){
        if ( Request::ajax() ) {
            $r           = new Referido;
            $res         = Array();
            $res         = $r->getReferido();

            return Response::json(
                array(
                    'rst'   => '1',
                    'msj'   => 'Detalle Cargado',
                    'datos' => $res
                )
            );
        }
    }

}
