<?php

class TablaRelacionController extends \BaseController
{

    /**
     * cargar areas, mantenimiento
     * POST /area/cargar
     *
     * @return Response
     */
    public function postRelacion()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $tr             = new TablaRelacion;
            $cargar         = Array();
            $cargar         = $tr->getRelacion();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $cargar
                )
            );
        }
    }

    public function postRelacionunico()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $tr             = new TablaRelacion;
            $cargar         = Array();
            $cargar         = $tr->getRelacionunico();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $cargar
                )
            );
        }
    }

    public function postRutaflujo()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            $rf             = new RutaFlujo;
            $cargar         = Array();
            $cargar         = $rf->getRutaFlujoProduccion();

            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $cargar
                )
            );
        }
    }

    public function postGuardar()
    {
        if( Request::ajax() ) {
            $tr         = new TablaRelacion;
            $datos      = array();
            $datos      = $tr->guardarRelacion();

            return Response::json(
                array(
                    'rst'    => 1,
                    'id'     => $datos->id,
                    'codigo' => Input::get('codigo')
                )
            );
        }
    }

}
