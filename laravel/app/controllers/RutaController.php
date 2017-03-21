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
            $res         = $r->ActividadDia();

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

             /*validate date*/
            $dayweek = date('w');
            $sumlast = 7 - $dayweek;
            $array_noregistrados = [];

            if($dayweek!=0){
                $event = date('Y-m-d',strtotime("-$dayweek days"));
                $fechaFirst = date('Y-m-d',strtotime($event. "+1 days"));
                $fechaLast = date('Y-m-d',strtotime("+$sumlast days"));
            }else{
                $fechaFirst = date('Y-m-d',strtotime("-6 days"));
                $fechaLast = date('Y-m-d');
            }
            /*end validate date*/
            $fechaActual = date("Y-m-d", strtotime(Input::get('finicio')));
            if($fechaActual >= $fechaFirst && $fechaActual <= $fechaLast){
                $rutadetalleId = Input::get('id');
                $rutadetalle = ActividadPersonal::find($rutadetalleId);
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
            }else{
                return Response::json(
                    array(
                    'rst'=>2,
                    'msj'=>'Error al Actualizar',
                    )
                );    
            }
        }
    }
    
         public function postActividadpersonalcreate()
    {   

        if ( Input::has('info') ) {

            /*validate date*/
            $dayweek = date('w');
            $sumlast = 7 - $dayweek;
            $array_noregistrados = [];

            if($dayweek!=0){
                $event = date('Y-m-d',strtotime("-$dayweek days"));
                $fechaFirst = date('Y-m-d',strtotime($event. "+1 days"));
                $fechaLast = date('Y-m-d',strtotime("+$sumlast days"));
            }else{
                $fechaFirst = date('Y-m-d',strtotime("-6 days"));
                $fechaLast = date('Y-m-d');
            }
            /*end validate date*/

            $info = Input::get('info');
            if(count($info) > 0){
                
                $persona_id=Auth::user()->id;
                /*si crea para otra persona*/
                if($info[0]['persona']){
                    $persona_id = $info[0]['persona'];
                }
                /*fin si crea para otra persona*/
                $Persona = Persona::find($persona_id);
             foreach ($info as $key => $value) {
                $fechaActual = date("Y-m-d", strtotime($value['finicio']));
                if($fechaActual >= $fechaFirst && $fechaActual <= $fechaLast){
                    DB::beginTransaction();
                    $ttranscurrido = $value['ttranscurrido'];
                    $minTrascurrido = explode(':', $ttranscurrido)[0] * 60 + explode(':', $ttranscurrido)[1];

                    $acti_personal = new ActividadPersonal();
                    $acti_personal->actividad = $value['actividad'];
                    $acti_personal->fecha_inicio = date("Y-m-d", strtotime($value['finicio']))." ".explode(' ',$value['hinicio'])[0];
                    $acti_personal->dtiempo_final = date("Y-m-d", strtotime($value['ffin']))." ".explode(' ',$value['hfin'])[0];
                    $acti_personal->ot_tiempo_transcurrido = $minTrascurrido;
                    $acti_personal->persona_id = $Persona->id;
                    $acti_personal->area_id = $Persona->area_id;
                    $acti_personal->usuario_created_at = Auth::user()->id;

                    $acti_personal->save();
                    DB::commit();
                }else{
                    $array_noregistrados[]=$fechaActual;
                }
            }
           
            return  array(
                            'rst'=>1,
                            'msj'=>'Registro realizado con éxito',
                            'registro' => implode(",", $array_noregistrados)
                    );  
        }}
    }

}
