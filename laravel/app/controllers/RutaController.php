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

    public function postCrearutagestion()
    {
        if ( Request::ajax() ) {
           /* var_dump(Input::all());
            exit();*/
            $r           = new Ruta;
            $res         = Array();
            $res         = $r->crearRutaGestion();

            return Response::json(
                array(
                    'rst'   => $res['rst'],
                    'msj'   => $res['msj']
                )
            );
        }
    }

    public function postFechaactual(){
        $fh=date("Y-m-d H:i:s");
        return Response::json(
                array(
                    'rst'   => 1,
                    'fecha'   => $fh
                )
            );
    }

}
