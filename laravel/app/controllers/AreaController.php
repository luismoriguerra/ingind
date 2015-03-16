<?php
class AreaController extends \BaseController
{
    public function postListar()
    {
        if ( Request::ajax() ) {
            $a      = new Area;
            $listar = Array();
            $listar = $a->getArea();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }

}
