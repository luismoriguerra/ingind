<?php
class RutaDetalleController extends \BaseController
{

    public function postCargarrd()
    {
        if ( Request::ajax() ) {
            $r           = new RutaDetalle;
            $res         = Array();
            $res         = $r->getRutadetalle();

            return Response::json(
                array(
                    'rst'   => '1',
                    'msj'   => 'Detalle Cargado',
                    'datos' => $res
                )
            );
        }
    }

    public function postCargartramite()
    {
        if ( Request::ajax() ) {
            $r           = new RutaDetalle;
            $res         = Array();
            $res         = $r->getTramite();

            return Response::json(
                array(
                    'rst'   => '1',
                    'msj'   => 'Detalle Cargado',
                    'datos' => $res
                )
            );
        }
    }

    public function postCargarrdv()
    {
        if ( Request::ajax() ) {
            $r           = new RutaDetalle;
            $res         = Array();
            $res         = $r->getRutadetallev();

            return Response::json(
                array(
                    'rst'   => '1',
                    'msj'   => 'Detalle Cargado',
                    'datos' => $res
                )
            );
        }
    }

    public function postListar()//aqui listará las areas unicas
    {
        if ( Request::ajax() ) {
            $r      = new RutaDetalle;
            $listar = Array();
            $listar = $r->getListaareas();
            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }

    public function postCargardetalle()
    {
        $r          = new RutaDetalle;
        $res        = Array();
        $res        = $r->getRutadetalle();

        if ( Request::ajax() ) {
            return Response::json(
                array(
                    'rst'=>'1',
                    'msj'=>'Detalle cargado',
                    'datos'=>$res
                )
            );
        }
    }

    public function postActualizartramite(){
        if ( Request::ajax() ) {
            $ruta_id=Input::get('ruta_id');
            $tabla_relacion_id=Input::get('tabla_relacion_id');

            DB::beginTransaction();
            $r=Ruta::find($ruta_id);
            $r['estado']=0;
            $r['usuario_updated_at']=Auth::user()->id;
            $r->save();

            $tr=TablaRelacion::find($tabla_relacion_id);
            $tr['estado']=0;
            $tr['usuario_updated_at']=Auth::user()->id;
            $tr->save();

            DB::commit();
            return Response::json(
                array(
                    'rst'=>'1',
                    'msj'=>'Se realizó con éxito'
                )
            );
        }
    }

    public function postEditnomb()
    {
        if ( Request::ajax() ) {
            $array_editables = Input::get('editables');
            foreach(json_decode($array_editables) as $value){
                /*update in rutas_detalle_verbo*/
                $rdv= RutaDetalleVerbo::find($value->rtverbo);
                $rdv['documento'] = $value->edit;
                $rdv['usuario_updated_at']= Auth::user()->id;
                $rdv->save(); 
                /*end update in rutas_detalle_verbo */
                /*update in history(sustentos,referidos)*/
                $referido = Referido::where('ruta_detalle_verbo_id', '=', $value->rtverbo)->get();
                if($referido){
                    $referido[0]['referido'] = $value->edit;
                    $referido[0]['usuario_updated_at']= Auth::user()->id;
                    $referido[0]->save();
                }else{
                    $sustento= Sustento::where('ruta_detalle_verbo_id', '=', $value->rtverbo)->get();
                    $sustento[0]['sustento'] = $value->edit;
                    $sustento[0]['usuario_updated_at']= Auth::user()->id;
                    $sustento[0]->save(); 
                }
                /*end update in history(sustentos,referidos)*/               
            }
            return Response::json(array(
                    'rst'=>'1',
                    'id_updated'=>json_decode($array_editables)[0]->rutadetalleid,
                    'msj'=>'Se realizó con éxito'
                )
            );
        }
    }

    public function postEditiempotra()
    {
        if ( Request::ajax() ) {
            $datos = json_decode(Input::get('datos'));
            $rd = RutaDetalle::find($datos->id);
            $rd['dtiempo']= $datos->tiempo;
            $rd['tiempo_id']= $datos->tiempoid;
            $rd['motivo_edit']= $datos->motivo;
            $rd['usuario_updated_at']= Auth::user()->id;
            $rd->save();

            return Response::json(array(
                    'rst'=>'1',
                    'id_updated' =>$datos->id,
                    'msj'=>'Se realizó con éxito'
                )
            );
        }
    }

    public function postSaverdverbo(){
        //prueba
        if ( Request::ajax() ) {
            $datos = json_decode(Input::get('datos'));
            $rdv = new RutaDetalleVerbo;
            $rdv['ruta_detalle_id'] = $datos->ruta_detalle_id;
            $rdv['nombre'] = $datos->nombre;
            $rdv['documento_id'] = $datos->documento;
            $rdv['condicion'] = $datos->condicion;
            $rdv['rol_id'] = $datos->rol_id;
            $rdv['verbo_id'] = $datos->verbo_id;
            $rdv['adicional'] = $datos->adicional;
            $rdv['orden'] = $datos->orden;
            $rdv->save();

            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro actualizado correctamente',
                'ruta_detalle_id' => $datos->ruta_detalle_id,
                )
            );
        }
    }

    public function postRetornarpaso()
    {
        if ( Request::ajax() ) {
            $rst='';
            $msj='';
            
            $rd_ant = RutaDetalle::find(Input::get('ruta_detalle_id'));
            if(Input::has('ruta_detalle_id') and  $rd_ant->ruta_detalle_id_ant){
                /*creating new norden to actual rd */
                DB::beginTransaction();
                for($i = 0; $i < 2; $i++){                    
                    if($i==1){ //paso anterios
                        $rd = RutaDetalle::find($rd_ant->ruta_detalle_id_ant);
//                      $rd = RutaDetalle::where('ruta_id',Input::get('ruta_id'))->where('condicion',0)->where('norden',Input::get('orden') - 1)->get()[0];
                        $rd->condicion=3;
                        $rd->save();
                    }else{ //paso actual == 0
                        $rd = RutaDetalle::find(Input::get('ruta_detalle_id'));
                        $rd->estado = 0;
                        $rd->save();
                    }

                    $fecha_inicio=date("Y-m-d H:i:s");

                    $rdetalle = new RutaDetalle;
                    $rdetalle['ruta_id'] = $rd->ruta_id;
                    $rdetalle['area_id'] = $rd->area_id;
                    $rdetalle['tiempo_id'] = $rd->tiempo_id;
                    $rdetalle['dtiempo'] = $rd->dtiempo;
                    $rdetalle['norden'] = $rd->norden;
                    $rdetalle['fecha_inicio'] =  ($i==1) ? $fecha_inicio : NULL; 
                    if($i==1){
                        $sql="SELECT CalcularFechaFinal( '".$fecha_inicio."', (".$rd->dtiempo."*1440), ".$rd->area_id." ) fproy";
                        $fproy= DB::select($sql);
                        $rdetalle['fecha_proyectada']=$fproy[0]->fproy;
                        $rdetalle['persona_responsable_id']=$rd->persona_responsable_id;
                        $rdetalle['ruta_detalle_id_ant']=$rd->ruta_detalle_id_ant;
                        $rdetalle['archivo']=$rd->archivo;
                    }
                    $rdetalle['estado_ruta'] = 1;
                    $rdetalle['created_at'] =  date("Y-m-d H:i:s");  
                    $rdetalle['usuario_created_at'] = Auth::user()->id;
                    $rdetalle->save();
                    
                    $rdverbo = RutaDetalleVerbo::where('ruta_detalle_id',$rd->id)->get();
                    foreach($rdverbo as $value){
                        if($i==0){ //paso anterios
                            $value->estado=0;
                            $value->save();                      
                        }
                        
                        $rdv = new RutaDetalleVerbo;
                        $rdv['ruta_detalle_id'] = $rdetalle->id;
                        $rdv['nombre'] = $value->nombre;
                        $rdv['documento_id'] = $value->documento_id;
                        $rdv['condicion'] = $value->condicion;
                        $rdv['rol_id'] = $value->rol_id;
                        $rdv['verbo_id'] = $value->verbo_id;
                        $rdv['orden'] = $value->orden;
                        $rdv['created_at'] = date("Y-m-d H:i:s");  
                        $rdv['usuario_created_at'] = Auth::user()->id;
                        $rdv->save();
                    }
                    /*end creating new norden to actual rd */
                }
                $msj='Se retornó con éxito';
                $rst=1;
                 DB::commit();
        }else{
            $msj='No se logró retornar,Comunicarse con la Gerencia de Modernización';
            $rst=2;
        }
            return Response::json(array(
                'rst'=>$rst,
                'msj'=>$msj
                )
            );
        }
    }

    public function postDeleterdv(){
        if ( Request::ajax() ) {
            $datos = json_decode(Input::get('datos'));
            $rdv = RutaDetalleVerbo::find($datos->ruta_detalle_verbo_id);
            $rdv['estado']= 0;
            $rdv['usuario_updated_at']=Auth::user()->id;
            $rdv->save();
            return Response::json(
                array(
                'rst'=>1,
                'msj'=>'Registro eliminado correctamente',
                'ruta_detalle_id' => $datos->ruta_detalle_id,
                )
            );
        }
    }

    public function postActualizar(){
        if ( Request::ajax() ) {
            DB::beginTransaction();

            $rdid=Input::get('ruta_detalle_id');
            $verbo_r = Input::get('vreferido');
            $rd = RutaDetalle::find($rdid);

            $r=Ruta::find($rd->ruta_id);
            $tablaReferido=Referido::where('ruta_id','=',$r->id)->first();

            $alerta= Input::get('alerta');
            $alertaTipo= Input::get('alerta_tipo');

            if( Input::get('verbog') OR Input::get('codg') OR Input::get('obsg')){
            $verbog= explode( "|",Input::get('verbog') );
            $codg= explode( "|",Input::get('codg') );
            $obsg= explode( "|",Input::get('obsg') );
            $coddocg= explode( "|",Input::get('coddocg') );

            if(Input::has('coddocdig')){
                $coddocdig= explode( "|",Input::get('coddocdig')); 
            }
                
                for( $i=0; $i<count($verbog); $i++ ){
                    $rdv= RutaDetalleVerbo::find($verbog[$i]);
                    $rdv['finalizo'] = '1';

                    if(isset($coddocdig[$i]) && $coddocdig[$i]!=''){
                        $rdv['doc_digital_id'] = $coddocdig[$i];
                    }

                    $rdv['documento'] = $codg[$i];
                    $rdv['observacion'] = $obsg[$i];
                    $rdv['usuario_updated_at']= Auth::user()->id;
                    $rdv->save();

                    if( $rdv->verbo_id==1 ){
                        $refid=Referido::where(
                                    'tipo','=','1'
                                )
                                ->where(
                                    'ruta_id','=',$r->id
                                )
                                ->where(
                                    'tabla_relacion_id','=',$tablaReferido->tabla_relacion_id
                                )
                                ->where(
                                    'ruta_detalle_id','=',$rd->id
                                )
                                ->first();
                        $referidoid='';

                        if( count($refid)==0 ){
                            $referido=new Referido;
                            $referido['ruta_id']=$r->id;
                            $referido['tabla_relacion_id']=$tablaReferido->tabla_relacion_id;
                            $referido['ruta_detalle_id']=$rd->id;
                            $referido['norden']=$rd->norden;
                            $referido['estado_ruta']=$rd->estado_ruta;
                            $referido['tipo']=1;
                            $referido['usuario_created_at']=Auth::user()->id;
                            $referido->save();
                            $referidoid= $referido->id;
                        }
                        else{
                            $referidoid=$refid->id;
                        }

                   
                        if( $rdv->id != $verbo_r){
                            $sustento=new Sustento;
                            $sustento['referido_id']=$referidoid;
                            $sustento['ruta_detalle_id']=$rd->id;
                            $sustento['ruta_detalle_verbo_id']=$rdv->id;
                            $sustento['documento_id']=$rdv->documento_id;
                            $sustento['sustento']=$rdv->documento;
                            $sustento['fecha_hora_sustento']=$rdv->updated_at;
                            $sustento['usuario_sustento']=$rdv->usuario_updated_at;
                            $sustento['usuario_created_at']=Auth::user()->id;
                            $sustento->save();
                        }
                        else{
                            $referido=Referido::find($referidoid);
                            $referido['documento_id']=$rdv->documento_id;
                            $referido['ruta_detalle_verbo_id']=$rdv->id; /*$referido['id_tipo']=$rdv->id;*/
                            $referido['referido']=$rdv->documento;
                            $referido['fecha_hora_referido']=$rdv->updated_at;
                            $referido['usuario_referido']=$rdv->usuario_updated_at;
                            $referido['usuario_updated_at']=Auth::user()->id;
                            $referido->save();
                        }
                    }
                }
            }

            $datos=array();
            if ( Input::get('tipo_respuesta') ) {
                if(Input::get('archivado')==2 && Input::has('archivado')){
                    $rd['archivado']=2;
                }
                $rd['dtiempo_final']= Input::get('respuesta');
                $rd['tipo_respuesta_id']= Input::get('tipo_respuesta');
                $rd['tipo_respuesta_detalle_id']= Input::get('tipo_respuesta_detalle');
                $rd['observacion']= Input::get('observacion');
                $rd['alerta']= Input::get('alerta');
                $rd['alerta_tipo']= Input::get('alerta_tipo');
                $rd['usuario_updated_at']= Auth::user()->id;
                $rd->save();

                $parametros=array(
                    'email'     => Input::get('email')
                );

                $query='
                    SELECT condicion,sum(finalizo) suma,count(condicion) cant
                    FROM rutas_detalle_verbo
                    WHERE ruta_detalle_id='.$rdid.'
                    AND estado=1
                    GROUP BY condicion
                    HAVING suma=cant
                    ORDER BY condicion DESC';
                $querycondicion= DB::select($query);
                if( count($querycondicion) >0 ){
                    $siguiente= $querycondicion[0]->condicion;
                }
                else{
                    $siguiente= "0";
                }

                $query='
                    SELECT condicion
                    FROM rutas_detalle_verbo
                    WHERE ruta_detalle_id='.$rdid.'
                    AND estado=1
                    GROUP BY condicion
                    ORDER BY condicion DESC';
                $querycondicion= DB::select($query);
                $siguientefinal="0";
                if( count($querycondicion) >0 ){
                    $siguientefinal= $querycondicion[0]->condicion;
                }

                $validaSiguiente= DB::table('rutas_detalle AS rd')
                                    ->select(
                                        'rd.id',
                                        'rd.estado_ruta',
                                        'rd.fecha_inicio', 
                                        DB::raw('now() AS ahora') 
                                    )
                                    ->join(
                                        'areas AS a',
                                        'a.id', '=', 'rd.area_id'
                                    )
                                    ->where('rd.ruta_id', '=', $rd->ruta_id)
                                    ->whereRaw('dtiempo_final is null')
                                    //->where('rd.norden', '>', $rd->norden)
                                    ->where('rd.condicion', '=', '0')
                                    ->where('rd.estado', '=', '1')
                                    ->orderBy('rd.norden','ASC')
                                    ->get();
                                    
                if( count($validaSiguiente)>0  and ( ($alerta==1 and $alertaTipo==1) or ($alerta==0 and $alertaTipo==0) ) ){
                    $idSiguiente = 0;
                    $faltaparalelo=0;
                    $inciodato=0;
                    $terminodato=0;
                    for ($i=0; $i<count($validaSiguiente); $i++) {
                        if(trim($validaSiguiente[$i]->fecha_inicio)!=''){
                            $faltaparalelo++;
                        }
                        elseif($faltaparalelo==0 and $inciodato==0 and $terminodato==0 and $validaSiguiente[$i]->estado_ruta==1){ // cuando se coge el primer registro
                            $inciodato++;
                            if($siguiente==0){ // cuando es una ruta normal
                                $idSiguiente= $validaSiguiente[$i]->id;
                                $fechaInicio= $validaSiguiente[$i]->ahora;
                            }
                            /*elseif($siguiente==1){ // condiciona +1
                                $idinvalido= $validaSiguiente[($siguientefinal-1)]->id;
                                $rdinv= RutaDetalle::find($idinvalido);
                                $rdinv['condicion']=1;
                                $rdinv['usuario_updated_at']= Auth::user()->id;
                                $rdinv->save();

                                if($siguientefinal==2){
                                    $i++;
                                }

                                $idSiguiente= $validaSiguiente[0]->id;
                                $fechaInicio= $validaSiguiente[0]->ahora;
                            }*/
                            elseif($siguiente>=1){ // condicional +n
                                for($j=0; $j<$siguientefinal; $j++){
                                    if( $siguiente==($j+1) ){
                                        if(!empty($validaSiguiente[($i+$j)]->id)){ //si existe dentro del array de valida siguiente
                                            $idSiguiente= $validaSiguiente[($i+$j)]->id;
                                            $fechaInicio= $validaSiguiente[($i+$j)]->ahora;
                                        }
                                    }
                                    else{
/*                                        var_dump($validaSiguiente);
                                        var_dump($i);
                                        var_dump($j);
                                        exit();*/
                                        $idinvalido= $validaSiguiente[($i+$j)]->id;
                                        $rdinv= RutaDetalle::find($idinvalido);
                                        $rdinv['condicion']=1;
                                        $rdinv['usuario_updated_at']= Auth::user()->id;
                                        $rdinv->save();
                                    }

                                    if( ($j+1)==$siguientefinal ){
                                        $i=$i+$j;
                                    }
                                }
                            }

                            if($idSiguiente != 0){ //si existe actualizara
                                $rd2 = RutaDetalle::find($idSiguiente);
                                $rd2['fecha_inicio']= $fechaInicio ;
                                    $sql="SELECT CalcularFechaFinal( '".$fechaInicio."', (".$rd2->dtiempo."*1440), ".$rd2->area_id." ) fproy";
                                    $fproy= DB::select($sql);
                                $rd2['fecha_proyectada']=$fproy[0]->fproy;
                                $rd2['ruta_detalle_id_ant']=$rdid;
                                $rd2['usuario_updated_at']= Auth::user()->id;
                                $rd2->save();                                
                            }
                        }
                        elseif($faltaparalelo==0 and $inciodato>0 and $terminodato==0 and $validaSiguiente[$i]->estado_ruta==2){ // cuando es paralelo iniciar tb
                            $rd3 = RutaDetalle::find($validaSiguiente[$i]->id);
                            $rd3['fecha_inicio']= $validaSiguiente[$i]->ahora;
                                $sql="SELECT CalcularFechaFinal( '".$fechaInicio."', (".$rd3->dtiempo."*1440), ".$rd3->area_id." ) fproy";
                                $fproy= DB::select($sql);
                            $rd3['fecha_proyectada']=$fproy[0]->fproy;
                            $rd3['ruta_detalle_id_ant']=$rdid;
                            $rd3['usuario_updated_at']= Auth::user()->id;
                            $rd3->save();
                        }
                        else{
                            $terminodato++;
                        }
                    }
                }
                elseif( count($validaSiguiente)==0 ){
                    $validaerror =  DB::table('rutas_detalle AS rd')
                                    ->select('rd.id')
                                    ->join(
                                        'areas AS a',
                                        'a.id', '=', 'rd.area_id'
                                    )
                                    ->where('rd.ruta_id', '=', $rd->ruta_id)
                                    ->where('rd.alerta', '!=', 0)
                                    ->where('rd.estado', '=', 1)
                                    ->get();

                    $rutaFlujo= DB::table('rutas')
                                    ->where('id', '=', $rd->ruta_id)
                                    ->get();
                    $rf = RutaFlujo::find($rutaFlujo[0]->ruta_flujo_id);

                    if( count($validaerror)>0 ){
                        $rf['n_flujo_error']=$rf['n_flujo_error']*1+1;
                    }
                    else{
                        $rf['n_flujo_ok']=$rf['n_flujo_ok']*1+1;
                    }
                    $rf['usuario_updated_at']=Auth::user()->id;
                    $rf->save();
                }
                DB::commit();
                /******************************************Validación del Documento***********************************************/
                /*********************************************************************************************************************/
                return Response::json(array(
                    'rst'=>1,
                    'msj'=>'Se realizó con éxito',
                    'datos'=>$datos
                )); 
            }
            else{
                DB::commit();
                return Response::json(
                    array(
                        'rst'=>'1',
                        'msj'=>'Se realizó con éxito',
                        'datos'=>$datos
                    )
                );
            }
        }
    }


    // ARCHIVOS PROCESO DESMONTE
    public function postVerarchivosdesmontesmotorizado()
    {
      $array=array();
      
      if( Input::has('ruta_id') AND Input::get('ruta_id')!='' ){
        $array['ruta_id'] =" AND rd.ruta_id='".Input::get('ruta_id')."' ";
      }
      if( Input::has('norden') AND Input::get('norden')!='' ){
        $array['norden'] =" AND rd.norden<='".Input::get('norden')."' ";
      }

      //$data = Reporte::VerNroPasosTramite($array);
      //$cant_pasos = $data[0]->cant;
      $oData = RutaDetalle::verArchivosDesmontesMotorizado( $array );

      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$oData['data']
          )
      );
    }

    public function postActualizararchivodesmonte() {
        if ( Input::has('pago_archivo') ) {
            $archivo= Input::get('pago_archivo');
            $nombre= Input::get('pago_nombre');
            $ruta_detalle_id = Input::get('ruta_detalle_id');
            $rpta='';

            if (count($archivo) > 0) {
                for ($i=0; $i< count($archivo); $i++) {
                    $url = "img/admin/ruta_detalle/".date("Y-m-d")."-".$ruta_detalle_id.'-'.str_replace(' ', '', $nombre[$i]);
                    //echo $dato[1].' :::: '.$url.'<br>';
                    $this->fileToFile($archivo[$i], $url);
                    if($i==0){
                        $rpta=$url;
                    }
                    else{
                        $rpta.="|".$url;
                    }
                }
                        
                $rutaDetalle = RutaDetalle::find($ruta_detalle_id);
                if( trim($rutaDetalle->archivo)!='' ) {
                    if ($rpta!='') {
                        $rpta.='|'.trim($rutaDetalle->archivo);
                    }
                    else{
                        $rpta=trim($rutaDetalle->archivo);
                    }
                }

                $rutaDetalle->archivo=$rpta;
                $rutaDetalle->usuario_updated_at = Auth::user()->id;
                $rutaDetalle->save();
            }
        }

        return Response::json(
                    array(
                        'rst'=>'1',
                        'msj'=>'Se realizó con éxito'
                    )
                );
    }

    public function postEliminararchivodesmonte() {

        if ( Input::has('archivos') ) {
            $archivos= Input::get('archivos');
            $ruta_detalle_id = Input::get('id');

            $rutaDetalle = RutaDetalle::find($ruta_detalle_id);
            $rutaDetalle->archivo=$archivos;
            $rutaDetalle->usuario_updated_at = Auth::user()->id;
            $rutaDetalle->save();            
        }

        return Response::json(
                        array(
                            'rst'=>'1',
                            'msj'=>'Se realizó con éxito'
                        )
                    );
    }
    // --

    public function fileToFile($file, $url)
    {

        if ( !is_dir('img/admin/ruta_detalle/') ) {
            mkdir('img/admin/ruta_detalle/',0777);
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

}
