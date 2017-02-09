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

    public function postOrdentrabajo()
    {
        if ( Request::ajax() ) {
           /* var_dump(Input::all());
            exit();*/
            $r           = new Ruta;
            $res         = Array();
            $res         = $r->crearOrdenTrabajo();

            return Response::json(
                array(
                    'rst'   => $res['rst'],
                    'msj'   => $res['msj']
                )
            );
        }
    }
    
        public function postOrdentrabajodia()
    {
        if ( Request::ajax() ) {
           /* var_dump(Input::all());
            exit();*/
            $r           = new Ruta;
            $res         = Array();
            $res         = $r->OrdenTrabajoDia();

            return Response::json(array('rst'=>1,'datos'=>$res));
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
    
        public function postEditaractividad()
    {

        if ( Request::ajax() ) {
            $rutadetalleId = Input::get('id');
            $rutadetalle = RutaDetalle::find($rutadetalleId);
            $rutadetalle->fecha_inicio = date("Y-m-d", strtotime(Input::get('finicio')))." ".explode(' ',Input::get('hinicio'))[0];
            $rutadetalle->dtiempo_final = date("Y-m-d", strtotime(Input::get('ffin')))." ".explode(' ',Input::get('hfin'))[0];
            $ttranscurrido =  Input::get('ttranscurrido');
            $minTrascurrido = explode(':', $ttranscurrido)[0] * 60 + explode(':', $ttranscurrido)[1];
            $rutadetalle->ot_tiempo_transcurrido =$minTrascurrido;
            $rutadetalle->usuario_updated_at = Auth::user()->id;
            $rutadetalle->save();
            
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                )
            );    

        }
    }

}
