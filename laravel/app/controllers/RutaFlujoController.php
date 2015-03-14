<?php
class RutaFlujoController extends \BaseController
{
    public function postCargar()
    {
        if ( Request::ajax() ) {
            $rf     = new RutaFlujo();
            $cargar         =Array();
            $cargar         = $rf->getRutasFlujo();

            return Response::json(
                array(
                    'rst'   =>1,
                    'datos' =>$cargar
                )
            );
        }
    }

}
