<?php
class RFController extends \BaseController
{

    public function postRegistrar()
    {
        if ( Request::ajax() ) {
            $r = RutaFlujo::getGuardar();
            return Response::json(
                array(
                    'rst'   => 1,
                    'msj'   => $r['mensaje'],
                    'ruta_flujo_id'=>$r['ruta_flujo_id']
                )
            );
        }
    }

}
