<?php
class RutaController extends \BaseController
{
    
    public function postListarmicro(){
        if ( Request::ajax() ) {
            $res= RutaDetalleMicro::getListar();
            return Response::json(array('rst'=>1,'datos'=>$res));
        }
    }
    
    public function postCrearmicroproceso() {
        if (Request::ajax()) {
            $regex = 'regex:/^([a-zA-Z .,ñÑÁÉÍÓÚáéíóú]{2,60})$/i';
            $required = 'required';
            $reglas = array(
                'actividad' => $required . '|' . $regex,
            );

            $mensaje = array(
                'required' => ':attribute Es requerido',
                'regex' => ':attribute Solo debe ser Texto',
            );

            $validator = Validator::make(Input::all(), $reglas, $mensaje);

//            if ($validator->fails()) {
//                return Response::json(array('rst' => 2, 'msj' => $validator->messages()));
//            }

            $id = Input::get('id');
            $ruta_flujo_id2 = Input::get('ruta_flujo_id2');
            $norden = Input::get('norden');
            $ruta_flujo_id=Input::get('ruta_flujo_id');

            DB::table('rutas_flujo_detalle_micro')
                    ->where('ruta_flujo_id', $ruta_flujo_id)
                    ->update(array('estado' => 0));
            
            for ($i = 0; $i < count($ruta_flujo_id2); $i++) {
                if ($id[$i] == '') {
                    $rfdm = new RutaFlujoDetalleMicro;
                    $rfdm->ruta_flujo_id = $ruta_flujo_id;
                    $rfdm->norden = $norden[$i];
                    $rfdm->ruta_flujo_id2 = $ruta_flujo_id2[$i];
                    $rfdm->estado = 1;
                    $rfdm->usuario_created_at = Auth::user()->id;
                }
                if (($id[$i] !== '')) {
                    $rfdmId = $id[$i];
                    $rfdm = RutaFlujoDetalleMicro::find($rfdmId);
                    $rfdm->ruta_flujo_id = $ruta_flujo_id;
                    $rfdm->norden = $norden[$i];
                    $rfdm->ruta_flujo_id2 = $ruta_flujo_id2[$i];
                    $rfdm->estado = 1;
                    $rfdm->usuario_updated_at = Auth::user()->id;
                }
                $rfdm->save();
            }

            return Response::json(array('rst' => 1, 'msj' => 'Registro realizado correctamente'));
        }
    }

    public function postListardetalleruta(){
        if ( Request::ajax() ) {
            $res=Ruta::getlistarDetalleRuta();
            return Response::json(array('rst'=>1,'datos'=>$res));
        }
    }
    
    public function postCargarmicro(){
        if ( Request::ajax() ) {
            $res=Ruta::getCargarMicro();
            return Response::json(array('rst'=>1,'datos'=>$res));
        }
    }
    
        public function postCrearmicro()
    {
        if ( Request::ajax() ) {
            $r           = new Ruta;
            $res         = Array();
            $res         = $r->crearRutaMicro();

            return Response::json(
                array(
                    'rst'   => $res['rst'],
                    'msj'   => $res['msj']
                )
            );
        }
    }

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
        $f=date("Y-m-d");
        $h=date("H:i:s",strtotime("-1 minute"));
        return Response::json(
                array(
                    'rst'   => 1,
                    'fecha'   => $f,
                    'hora'    => $h
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
            $fechaActual = date("Y-m-d", strtotime(Input::get('hinicio'))); //finicio

            
            if($fechaActual >= $fechaFirst && $fechaActual <= $fechaLast){
                $rutadetalleId = Input::get('id');
                $rutadetalle = ActividadPersonal::find($rutadetalleId);
//                $rutadetalle->fecha_inicio = date("Y-m-d", strtotime(Input::get('finicio')))." ".explode(' ',Input::get('hinicio'))[0];
//                $rutadetalle->dtiempo_final = date("Y-m-d", strtotime(Input::get('ffin')))." ".explode(' ',Input::get('hfin'))[0];
                $rutadetalle->fecha_inicio = date("Y-m-d")." ".explode(' ',Input::get('hinicio'))[0]; // hinicio
                $rutadetalle->dtiempo_final = date("Y-m-d")." ".explode(' ',Input::get('hfin'))[0];   // hfin
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
                    $adicional= (((strtotime($value['ffin'])-strtotime($value['finicio']))/ 86400)*24)*60;
                    $minTrascurrido=$adicional+$minTrascurrido;
                    $acti_personal = new ActividadPersonal();
                    $acti_personal->actividad = $value['actividad'];
//                    $acti_personal->fecha_inicio = date("Y-m-d", strtotime($value['finicio']))." ".explode(' ',$value['hinicio'])[0];
//                    $acti_personal->dtiempo_final = date("Y-m-d", strtotime($value['ffin']))." ".explode(' ',$value['hfin'])[0];
                    $acti_personal->fecha_inicio = date("Y-m-d")." ".explode(' ',$value['hinicio'])[0];
                    $acti_personal->dtiempo_final = date("Y-m-d")." ".explode(' ',$value['hfin'])[0];
                    $acti_personal->ot_tiempo_transcurrido = $minTrascurrido;
                    $acti_personal->cantidad = $value['cantidad'];
                    $acti_personal->tipo = $value['tipo'];
                    if(array_key_exists('actividadasignada', $value)){
                    if(trim($value['actividadasignada'])!=''){
                        $acti_personal->actividad_asignada_id = $value['actividadasignada'];
                    }else {
                        $acti_personal->actividad_asignada_id = null;
                    }}else {
                        $acti_personal->actividad_asignada_id = null;
                    }
                    $acti_personal->persona_id = $Persona->id;
                    $acti_personal->area_id = $Persona->area_id;
                    $acti_personal->usuario_created_at = Auth::user()->id;

                    $acti_personal->save();
                    
                    if($acti_personal->id){
                                
                                /************ Marcar actividad asignada como respondida ************/
                                if($acti_personal->actividad_asignada_id!=null){
                                    $asignada=ActividadPersonal::find($acti_personal->actividad_asignada_id);
                                    $asignada->respuesta=1;
                                    $asignada->save();
                                    
                                    $acti_personal->ruta_detalle_id=$asignada->ruta_detalle_id;
                                    $acti_personal->ruta_id=$asignada->ruta_id;
                                    $acti_personal->save();
                                    /************ Actualizar Detalle de Ruta ************/
                                    if($asignada->actividad_categoria_id){
                                            $rutadetalle =RutaDetalle::where('ruta_id','=',$asignada->ruta_id)
                                                                            ->first();
                                            $rutadetalle->dtiempo_final =date('Y-m-d H:i:s');
                                            $rutadetalle->tipo_respuesta_id = 2;
                                            $rutadetalle->tipo_respuesta_detalle_id = 1;
                                            $rutadetalle->observacion = 'Ok';
                                            $rutadetalle->usuario_updated_at = Auth::user()->id;
                                            $rutadetalle->save();

                                        /*************************************************************/
                                        /************ Actualizar Verbos de la ruta detalle ************/
                                        $qrutaDetalleVerbo = DB::table('rutas_detalle_verbo')
                                                ->where('ruta_detalle_id', '=', $rutadetalle->id)
                                                ->where('estado', '=', '1')
                                                ->orderBy('orden', 'ASC')
                                                ->get();

                                        if (count($qrutaDetalleVerbo) > 0) {
                                            foreach ($qrutaDetalleVerbo as $rdv) {
                                                $rutaDetalleVerbo = RutaDetalleVerbo::find($rdv->id);
                                                $rutaDetalleVerbo['documento'] = '';
                                                $rutaDetalleVerbo['observacion'] = '.';
                                                $rutaDetalleVerbo['finalizo'] = 1;
                                                $rutaDetalleVerbo['usuario_updated_at'] = Auth::user()->id;
                                                $rutaDetalleVerbo->save();
                                            }
                                        }
                                    } 
                                    else{
                                       $qrutaDetalleVerbo = DB::table('rutas_detalle_verbo')
                                                ->where('ruta_detalle_id', '=', $asignada->ruta_detalle_id)
                                                ->where('usuario_updated_at', '=',$asignada->persona_id)
                                               ->where('finalizo', '=',0)
                                                ->where('estado', '=', '1')
                                                ->orderBy('orden', 'ASC')
                                                ->get();
                                       
                                       if (count($qrutaDetalleVerbo) > 0) {
                                            foreach ($qrutaDetalleVerbo as $rdv) {
                                                $rutaDetalleVerbo = RutaDetalleVerbo::find($rdv->id);
                                                $rutaDetalleVerbo['documento'] = '';
                                                $rutaDetalleVerbo['observacion'] = '.';
                                                $rutaDetalleVerbo['finalizo'] = 1;
                                                $rutaDetalleVerbo->save();
                                            }
                                        }
                                        
                                    }
                                }
                                
//                        var_dump($value['archivo'][1]);exit();
                            for($i=1;$i<count($value['archivo']);$i++){
                                $dato=explode('|', $value['archivo'][$i]);
                                
                                $url = "file/actividad/".date("Y-m-d")."-".$dato[0];
                                $this->fileToFile($dato[1], $url);
                                $ruta=date("Y-m-d").'-'.$dato[0];
                                
                                $acti_personal_archivo = new ActividadPersonalArchivo();
                                $acti_personal_archivo->actividad_personal_id=$acti_personal->id;
                                $acti_personal_archivo->ruta=$ruta;
                                $acti_personal_archivo->usuario_created_at = Auth::user()->id;
                                $acti_personal_archivo->save();
                            }
                        
                            for($i=1;$i<count($value['documento']);$i++){

                                $acti_personal_archivo = new ActividadPersonalDocdigital();
                                $acti_personal_archivo->actividad_personal_id=$acti_personal->id;
                                $acti_personal_archivo->doc_digital_id=$value['documento'][$i];
                                $acti_personal_archivo->usuario_created_at = Auth::user()->id;
                                $acti_personal_archivo->save();
                            }
                        
                    }
                    
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
    
            public function fileToFile($file, $url){
        if ( !is_dir('file') ) {
            mkdir('file',0777);
        }
        if ( !is_dir('file/meta') ) {
            mkdir('file/actividad',0777);
        }

        list($type, $file) = explode(';', $file);
        list(, $type) = explode('/', $type);
        if ($type=='jpeg') $type='jpg';
        if (strpos($type,'document')!==False) $type='docx';
        if (strpos($type, 'sheet') !== False) $type='xlsx';
        if (strpos($type, 'pdf') !== False) $type='pdf';
        if ($type=='plain') $type='txt';
        list(, $file)      = explode(',', $file);
        $file = base64_decode($file);
        file_put_contents($url , $file);
        return $url. $type;
    }
    
        public function postActividadpersonalasignado()
    {            
//            var_dump("listo");exit();

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
                    $adicional= (((strtotime($value['ffin'])-strtotime($value['finicio']))/ 86400)*24)*60;
                    $minTrascurrido=$adicional+$minTrascurrido;
                    $acti_personal = new ActividadPersonal();
                    $acti_personal->actividad = $value['actividad'];
                    $acti_personal->fecha_inicio = date("Y-m-d", strtotime($value['finicio']))." ".explode(' ',$value['hinicio'])[0];
                    $acti_personal->dtiempo_final = date("Y-m-d", strtotime($value['ffin']))." ".explode(' ',$value['hfin'])[0];
                    $acti_personal->ot_tiempo_transcurrido = $minTrascurrido;
                    $acti_personal->cantidad = $value['cantidad'];
                    $acti_personal->tipo = $value['tipo'];
                    $acti_personal->actividad_categoria_id = @$value['actividad_categoria_id'];
                    
                    if(array_key_exists('actividadasignada', $value)){
                    if(trim($value['actividadasignada'])!=''){
                        $acti_personal->actividad_asignada_id = $value['actividadasignada'];
                    }else {
                        $acti_personal->actividad_asignada_id = null;
                    }}else {
                        $acti_personal->actividad_asignada_id = null;
                    }
                    $acti_personal->persona_id = $Persona->id;
                    $acti_personal->area_id = $Persona->area_id;
                    $acti_personal->usuario_created_at = Auth::user()->id;
                    $acti_personal->save();
                     
                    if($acti_personal->id){
//                        var_dump($value['archivo'][1]);exit();
                            for($i=1;$i<count($value['archivo']);$i++){
                                $dato=explode('|', $value['archivo'][$i]);
                                $url = "file/actividad/".date("Y-m-d")."-".$dato[0];
                                $this->fileToFile($dato[1], $url);
                                $ruta=date("Y-m-d").'-'.$dato[0];
                                
                                $acti_personal_archivo = new ActividadPersonalArchivo();
                                $acti_personal_archivo->actividad_personal_id=$acti_personal->id;
                                $acti_personal_archivo->ruta=$ruta;
                                $acti_personal_archivo->usuario_created_at = Auth::user()->id;
                                $acti_personal_archivo->save();
                            }
                            
                            for($i=1;$i<count($value['documento']);$i++){
                                $acti_personal_archivo = new ActividadPersonalDocdigital();
                                $acti_personal_archivo->actividad_personal_id=$acti_personal->id;
                                $acti_personal_archivo->doc_digital_id=$value['documento'][$i];
                                $acti_personal_archivo->usuario_created_at = Auth::user()->id;
                                $acti_personal_archivo->save();

                                $sql=" UPDATE rutas r
                                        INNER JOIN rutas_detalle rd ON rd.ruta_id = r.id AND rd.condicion = 0 AND rd.estado = 1
                                        SET rd.persona_responsable_id=".$Persona->id.", rd.usuario_updated_at=".Auth::user()->id.", rd.updated_at=now()
                                        WHERE r.estado = 1
                                            AND rd.fecha_inicio IS NOT NULL
                                            AND dtiempo_final IS NULL
                                            AND (
                                                        r.id IN (SELECT r.ruta_id
                                                                FROM referidos r
                                                                WHERE r.doc_digital_id = ".$acti_personal_archivo->doc_digital_id.")
                                                        OR
                                                        rd.id IN (  SELECT s.ruta_detalle_id
                                                                    FROM sustentos s
                                                                    WHERE s.doc_digital_id = ".$acti_personal_archivo->doc_digital_id.")
                                                    )
                                            AND rd.area_id =".$Persona->area_id;
                                DB::update($sql);
                            }   
                            
                            if(trim($value['tipo_asignacion'])==2){
                                if(@$value['ruta_detalle_id']){
                                    for($i=0;$i<count($value['tramite']);$i++){
                                        if($value['tramite'][$i]!=0){
                                            $rudeve =RutaDetalleVerbo::find($value['tramite'][$i]);
                                            $rudeve->usuario_updated_at = $Persona->id;
                                            $rudeve->save();
                                        }
                                    }

                                    $rutadetalle= RutaDetalle::find($value['ruta_detalle_id']);
                                    $acti_personal->ruta_detalle_id=$rutadetalle->id;
                                    $acti_personal->ruta_id=$rutadetalle->ruta_id;
                                    $acti_personal->save();
                                    
                                }
                                
                            }
                            
                        if(trim($value['tipo_asignacion'])==1){
                                $categoria= ActividadCategoria::find($value['actividad_categoria_id']);

                                if(!$categoria->ruta_flujo_id){
                                    /************ Registrar Flujo ********* ************/
                                    $flujo=new Flujo;
                                    $flujo->area_id=Auth::user()->area_id;
                                    $flujo->categoria_id=17;
                                    $flujo->nombre=$categoria->nombre;
                                    $flujo->tipo_flujo=2;
                                    $flujo->usuario_created_at=Auth::user()->id;
                                    $flujo->save();

                                    /***************Registrar Flujo Respuesta********************************/
                                    $ftr=new FlujoTipoRespuesta;
                                    $ftr->flujo_id=$flujo->id;
                                    $ftr->tipo_respuesta_id=2;
                                    $ftr->tiempo_id=1;
                                    $ftr->dtiempo=0;
                                    $ftr->usuario_created_at=Auth::user()->id;
                                    $ftr->save();

                                    /************ Registrar Ruta Flujo ********* ************/
                                    if($flujo->id){
                                        $rutaflujo = new RutaFlujo;
                                        $rutaflujo->flujo_id = $flujo->id;
                                        $rutaflujo->persona_id = Auth::user()->id;
                                        $rutaflujo->area_id = Auth::user()->area_id;
                                        $rutaflujo->usuario_created_at = Auth::user()->id;
                                        $rutaflujo->save();
                                    }
                                    /***************************************************/
                                    $dias=date("Y-m-d", strtotime($value['ffin'])) - date("Y-m-d", strtotime($value['finicio']));                            
                                    /************ Registrar Detalle de Ruta ************/
                                    if($rutaflujo->id){
                                        $rutaflujodetalle = new RutaFlujoDetalle;
                                        $rutaflujodetalle->ruta_flujo_id = $rutaflujo->id;
                                        $rutaflujodetalle->area_id = Auth::user()->area_id;
                                        $rutaflujodetalle->tiempo_id = 2;
                                        $rutaflujodetalle->dtiempo = $dias+1;
                                        $rutaflujodetalle->norden = 1;
                                        $rutaflujodetalle->detalle = "Desarrollo del trabajo";
                                        $rutaflujodetalle->estado_ruta = 1;
                                        $rutaflujodetalle->usuario_created_at = Auth::user()->id;
                                        $rutaflujodetalle->save();
                                    }
                                    /*************************************************************/
                                    /************ Registrar Verbos de la ruta detalle ************/
                                    if($rutaflujodetalle->id){
                                        $rutaflujodetalleverbo=new RutaFlujoDetalleVerbo;
                                        $rutaflujodetalleverbo->ruta_flujo_detalle_id = $rutaflujodetalle->id;
                                        $rutaflujodetalleverbo->nombre = '';
                                        $rutaflujodetalleverbo->condicion = 0;
                                        $rutaflujodetalleverbo->rol_id = 4;
                                        $rutaflujodetalleverbo->verbo_id = 3;
    //                                    $rutaflujodetalleverbo->documento_id = 1;
                                        $rutaflujodetalleverbo->orden = 1;
                                        $rutaflujodetalleverbo->nombre = 'Inicio de actividad';
                                        $rutaflujodetalleverbo->usuario_created_at = Auth::user()->id;
                                        $rutaflujodetalleverbo->save();

                                        $rutaflujodetalleverbo=new RutaFlujoDetalleVerbo;
                                        $rutaflujodetalleverbo->ruta_flujo_detalle_id = $rutaflujodetalle->id;
                                        $rutaflujodetalleverbo->nombre = '';
                                        $rutaflujodetalleverbo->condicion = 0;
                                        $rutaflujodetalleverbo->rol_id = 4;
                                        $rutaflujodetalleverbo->verbo_id = 3;
    //                                    $rutaflujodetalleverbo->documento_id = 1;
                                        $rutaflujodetalleverbo->orden = 2;
                                        $rutaflujodetalleverbo->nombre = 'Fin de actividad';
                                        $rutaflujodetalleverbo->usuario_created_at = Auth::user()->id;
                                        $rutaflujodetalleverbo->save();
                                    }
                                    /*****************************************************************/
                                    /************ Actualizar ruta_flujo_id a la categoria ************/
                                    $categoria->ruta_flujo_id=$rutaflujo->id;
                                    $categoria->save();
                                    /*****************************************************************/
                                }

                                $rutaFlujo = RutaFlujo::find($categoria->ruta_flujo_id);
                            
                            /* * ***** ENCONTRAR CORRELATIVO EN ACTIVIDADES POR DÍA ********** */
                            $result=Ruta::getCorrelativoAct($Persona->id);
                            /* * ********************************************* *************** */

                            $tablarelacion = new TablaRelacion;
                            $tablarelacion->software_id = 1;
                            $tablarelacion->id_union = 'ACT - N° ' . str_pad($result+1, 2, '0', STR_PAD_LEFT) . ' - ' . $Persona->dni. ' - '. Auth::user()->areas->nemonico_doc;
                            $tablarelacion->sumilla = $value['actividad'];
                            $tablarelacion->estado = 1;
                            $tablarelacion->fecha_tramite =date('Y-m-d H:i:s');
                            $tablarelacion->usuario_created_at = Auth::user()->id;
                            $tablarelacion->save();
                            
                            /* * ************ ENCONTRAR RUTA *************** */

                            
                            $ruta = new Ruta;
                            $ruta['tabla_relacion_id'] = $tablarelacion->id;
                            $ruta['fecha_inicio'] = date('Y-m-d H:i:s');
                            $ruta['ruta_flujo_id'] = $rutaFlujo->id;
                            $ruta['flujo_id'] = $rutaFlujo->flujo_id;
                            $ruta['persona_id'] = $rutaFlujo->persona_id;
                            $ruta['area_id'] = $rutaFlujo->area_id;
                            $ruta['usuario_created_at'] = Auth::user()->id;
                            $ruta->save();

                            $qrutaDetalle = DB::table('rutas_flujo_detalle')
                                    ->where('ruta_flujo_id', '=', $rutaFlujo->id)
                                    ->where('estado', '=', '1')
                                    ->orderBy('norden', 'ASC')
                                    ->get();
                       
                            foreach ($qrutaDetalle as $rd) {
                                $cero='';
                                if($rd->norden<10){
                                    $cero='0';
                                }
                                $rutaDetalle = new RutaDetalle;
                                $rutaDetalle['ruta_id'] = $ruta->id;
                                $rutaDetalle['area_id'] = $rd->area_id;
                                $rutaDetalle['tiempo_id'] = $rd->tiempo_id;

                                $sql="SELECT CalcularFechaFinal( '".date('Y-m-d H:i:s')."', (".$rd->dtiempo."*1440), ".$rd->area_id." ) fproy";
                                $fproy= DB::select($sql);                                
                                $rutaDetalle['fecha_proyectada'] = $fproy[0]->fproy;

                                $rutaDetalle['dtiempo'] = $rd->dtiempo;
                                $rutaDetalle['detalle'] = $rd->detalle;
                                $rutaDetalle['norden'] =$cero.$rd->norden;
                                $rutaDetalle['estado_ruta'] = $rd->estado_ruta;
                                $rutaDetalle['usuario_created_at'] = Auth::user()->id;
                                if ($rutaDetalle->norden == 1) {
                                    $rutaDetalle['fecha_inicio'] = date('Y-m-d H:i:s');
                                }
                                $rutaDetalle->save();

                                $qrutaDetalleVerbo = DB::table('rutas_flujo_detalle_verbo')
                                        ->where('ruta_flujo_detalle_id', '=', $rd->id)
                                        ->where('estado', '=', '1')
                                        ->orderBy('orden', 'ASC')
                                        ->get();
                                
                                if (count($qrutaDetalleVerbo) > 0) {
                                    foreach ($qrutaDetalleVerbo as $rdv) {
                                        $rutaDetalleVerbo = new RutaDetalleVerbo;
                                        $rutaDetalleVerbo['ruta_detalle_id'] = $rutaDetalle->id;
                                        $rutaDetalleVerbo['nombre'] = $rdv->nombre;
                                        $rutaDetalleVerbo['condicion'] = $rdv->condicion;
                                        $rutaDetalleVerbo['rol_id'] = $rdv->rol_id;
                                        $rutaDetalleVerbo['verbo_id'] = $rdv->verbo_id;
                                        $rutaDetalleVerbo['documento_id'] = $rdv->documento_id;
                                        $rutaDetalleVerbo['orden'] = $rdv->orden;
                                        $rutaDetalleVerbo['usuario_created_at'] = Auth::user()->id;
                                    if($categoria->tipo==1){
                                        $rutaDetalleVerbo['usuario_updated_at'] = $Persona->id;
                                    }
                                        $rutaDetalleVerbo->save();
                                    }
                                }
                            }
                            /****************ruta_id en Actividad***********************/
                            $acti_personal->ruta_id=$ruta->id;
                            $acti_personal->ruta_detalle_id=$rutaDetalle->id;
                            $acti_personal->save();
                            /**********************************************/
                            
                        }
                        
                    }
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
