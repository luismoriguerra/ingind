<?php
class FlujoController extends \BaseController
{
    public function postListar()
    {
        if ( Request::ajax() ) {
            $f      = new Flujo();
            $listar = Array();
            $listar = $f->getFlujo();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }

}
