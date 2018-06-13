<?php

class DocumentoDigitalController extends \BaseController {

	public function postCargar()
    {
        if ( Request::ajax() ) {                 
            $documento_digital = DocumentoDigital::getDocumentosDigitales();
            return Response::json(array('rst'=>1,'datos'=>$documento_digital));
        }
    }
    
        public function postCargarcompleto()
    {
        if ( Request::ajax() ) {
            /*********************FIJO*****************************/
            $array=array();
            $array['where']='';$array['usuario']=Auth::user()->id;
            $array['limit']='';$array['order']='';
            
            if (Input::has('draw')) {
                if (Input::has('order')) {
                    $inorder=Input::get('order');
                    $incolumns=Input::get('columns');
                    $array['order']=  ' ORDER BY '.
                                      $incolumns[ $inorder[0]['column'] ]['name'].' '.
                                      $inorder[0]['dir'];
                }

                $array['limit']=' LIMIT '.Input::get('start').','.Input::get('length');
                $aParametro["draw"]=Input::get('draw');
            }
            /************************************************************/

            if( Input::has("plantilla") ){
                $plantilla=Input::get("plantilla");
                if( trim( $plantilla )!='' ){
                    $array['where'].=" AND pd.descripcion LIKE '%".$plantilla."%' ";
                }
            }

            if( Input::has("asunto") ){
                $asunto=Input::get("asunto");
                if( trim( $asunto )!='' ){
                    $array['where'].=" AND dd.asunto LIKE '%".$asunto."%' ";
                }
            }
            
            if( Input::has("titulo") AND Input::get('titulo')!='' ){
                 $titulo=explode(" ",trim(Input::get('titulo')));
                    for($i=0; $i<count($titulo); $i++){
                       $array['where'].=" AND dd.titulo LIKE '%".$titulo[$i]."%' ";
                    }
            }
            
            if( Input::has("created_at") ){
                $created_at=Input::get("created_at");
                //list($fechaIni,$fechaFin) = explode(" - ", $created_at);
                if( trim( $created_at )!='' ){
                   // $array['where'].=" AND DATE(dd.created_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."'";
                      $array['where'].=" AND DATE(dd.created_at)= '".$created_at."'";
                    
                }
            }
            
            if( Input::has("persona_u") ){
                $persona_u=Input::get("persona_u");
                if( trim( $persona_u )!='' ){
                    $array['where'].=" AND CONCAT_WS(' ',p1.paterno,p1.materno,p1.nombre) LIKE '%".$persona_u."%' ";
                }
            }
            
            if( Input::has("persona_c") ){
                $persona_c=Input::get("persona_c");
                if( trim( $persona_c )!='' ){
                    $array['where'].=" AND CONCAT_WS(' ',p.paterno,p.materno,p.nombre) LIKE '%".$persona_c."%' ";
                }
            }
            
            if( Input::has("solo_area") ){
                $usu_id=Auth::user()->id;
                $array['where'].="and dd.area_id IN (
                                        SELECT DISTINCT(a.id)
                                        FROM area_cargo_persona acp
                                        INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                       INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                        WHERE acp.estado=1
                                        AND cp.persona_id='.$usu_id.'
                        )";
            }  
            $array['order']=" order by `created_at` desc ";
            
            if( Input::get("tipo")==1 ){
                $cant  = DocumentoDigital::getCargarCount( $array );
                $aData = DocumentoDigital::getCargar( $array );
            }
            if(Input::get("tipo")==2){
                $cant  = DocumentoDigital::getCargarRelacionAreaCount( $array );
                $aData = DocumentoDigital::getCargarRelacionArea( $array );
            }
            
            $aParametro['rst'] = 1;
            $aParametro["recordsTotal"]=$cant;
            $aParametro["recordsFiltered"]=$cant;
            $aParametro['data'] = $aData;
            $aParametro['msj'] = "No hay registros aún";   
            return Response::json($aParametro);

        }
    }
  
        public function postEditartitulo()
    {
        if (Request::ajax() ) {
            
            $dd=DocumentoDigital::getVerificarTitulo();
            
            if($dd){
                return Response::json(
                array(
                    'rst' => 2,
                    'msj' => 'El título de Documento ya existe',
                )
                ); 
            }
            
            $documento_digital = DocumentoDigital::find(Input::get('id'));
            $plantilla = PlantillaDocumento::find($documento_digital->plantilla_doc_id);
            $documento= Documento::find($plantilla->tipo_documento_id);
            
            $cant=DocumentoDigital::getVerificarCorrelativo($documento->area,
            $documento_digital->tipo_envio,$documento->id,$documento_digital->persona_id,
            $plantilla->area_id,Input::get('titulo'),Input::get('id'));
      
            if($cant>=1){
                return Response::json(
                array(
                    'rst' => 2,
                    'msj' => 'El correlativo de Documento ya existe',
                )
                ); 
            }
            
            if(Input::get('ruta')==1 OR Input::get('rutadetallev')==1){
                    if(Input::get('ruta')==1){
                        $tb = TablaRelacion::where('doc_digital_id','=',Input::get('id'))->get();
                
                        foreach ($tb as $tabla_relacion){
                        $tabla_relacion->id_union = Input::get('titulofinal');
                        $tabla_relacion->save();
                        }
                    }
            
                    if(Input::get('rutadetallev')==1){
                        $rdv = RutaDetalleVerbo::where('doc_digital_id','=',Input::get('id'))->get();
                        $s= Sustento::where('ruta_detalle_verbo_id','=',$rdv->id)->get();
                        $r= Referido::where('ruta_detalle_id','=',$rdv->ruta_detalle_id)->get();
                        
                        foreach ($rdv as $rutadetallev){
                        $rutadetallev->documento = Input::get('titulofinal');
                        $rutadetallev->save();
                        }
                        foreach ($s as $sustento){
                        $sustento->sustento = Input::get('titulofinal');
                        $sustento->save();
                        }
                        foreach ($r as $referido){
                        $referido->referido = Input::get('titulofinal');
                        $referido->save();
                        }
                    }
            }
                  $documento_digital->titulo = Input::get('titulofinal');
                  $documento_digital->correlativo = Input::get('titulo');
                  $documento_digital->save();  
            
            
            return Response::json(
                array(
                    'rst' => 1,
                    'msj' => 'Registro Actualizado correctamente',
                )
            );
        }
    }
    
    public function postCorrelativo()
    {
        if ( Request::ajax() ) {
//            if(Input::get('t')=='' or Input::get('p')==''){
//                return Response::json(array('rst'=>1,'datos'=>array('correlativo'=>'000000')));
//            }
            $r = DocumentoDigital::Correlativo();
            return Response::json(array('rst'=>1,'datos'=>$r));
        }
    }

    public function postCambiarestado()
    {
        if (Request::ajax() && Input::has('id') && Input::has('estado')) {
            $plantilla_doc = PlantillaDocumento::find(Input::get('id'));
            $plantilla_doc->estado = Input::get('estado');
            $plantilla_doc->save();
            return Response::json(
                array(
                    'rst' => 1,
                    'msj' => 'Registro inhabilitado correctamente',
                )
            );
        }
    }
    
        public function postEditarfecha()
    {
        if (Request::ajax() && Input::has('id') && Input::has('fecha') && Input::has('comentario') )  {
            $a      = new DocumentoDigital;
            $listar = Array();
            $listar = $a->getEditarFecha();
            
            if($listar==1){
            $created=Input::get('fecha').' '.date ("h:i:s");     
            $DocDigital = new DocumentoFechaH;
            $DocDigital->documento_id = Input::get('id');
            $DocDigital->fecha_documento = $created;
            $DocDigital->comentario = Input::get('comentario');
            $DocDigital->usuario_created_at = Auth::user()->id;
            $DocDigital->save();
            
            return Response::json(
                array(
                    'rst' => 1,
                    'msj' => 'Registro Editado correctamente',
                )
            );
            }

        }
    }

    public function postCambiarestadodoc()
    {
        if (Request::ajax() && Input::has('id') && Input::has('estado')) {
            $a      = new DocumentoDigital;
            $listar = Array();
            $listar =$a->getCambiarEstadoDoc();
            return Response::json(
                array(
                    'rst' => 1,
                    'msj' => 'Registro actualizado correctamente',
                )
            );
    }
    }

    public function postEditar()
    {
        if ( Request::ajax() ) {
            $cambio_despues_de_proceso=0;
            $result=DocumentoDigital::getVerificarProcesoDoc(Input::get('iddocdigital'));
            if($result){
                $cambio_despues_de_proceso=1;
            }
            
            $html = Input::get('word', '');
            $html=str_replace('http://proceso.munindependencia.pe/', '', $html);
            $jefe = DB::table('personas')
             ->where(         
                        function($query){
                            $query->where('area_id', '=', Auth::user()->area_id)
                            ->orwhereRaw('FIND_IN_SET(' . Auth::user()->area_id . ',area_responsable)');
                        }
                    )
                    ->whereIn('rol_id', array(8,9,6))
                    ->where('estado',1)
                    ->get();
            
            DB::beginTransaction();                    
            $DocDigital = DocumentoDigital::find(Input::get('iddocdigital'));
            
            if($cambio_despues_de_proceso==1){
                $doc_dig_hi=new DocumentoDigitalHistorico;
                $doc_dig_hi->doc_digital_id=$DocDigital->id;
                $doc_dig_hi->titulo=$DocDigital->titulo;
                $doc_dig_hi->correlativo=$DocDigital->correlativo;
                $doc_dig_hi->asunto=$DocDigital->asunto;
                $doc_dig_hi->cuerpo=$DocDigital->cuerpo;
                $doc_dig_hi->plantilla_doc_id=$DocDigital->plantilla_doc_id;
                $doc_dig_hi->area_id=$DocDigital->area_id;
                $doc_dig_hi->persona_id=$DocDigital->persona_id;
                $doc_dig_hi->envio_total=$DocDigital->envio_total;
                $doc_dig_hi->tipo_envio=$DocDigital->tipo_envio;
                $doc_dig_hi->fecha_i_vacaciones=$DocDigital->fecha_i_vacaciones;
                $doc_dig_hi->fecha_f_vacaciones=$DocDigital->fecha_f_vacaciones;
                $doc_dig_hi->estado=$DocDigital->estado;
                $doc_dig_hi->usuario_created_at=$DocDigital->usuario_created_at;
                $doc_dig_hi->save();
            }
            //$DocDigital->titulo = Input::get('titulofinal');
            //$DocDigital->correlativo = Input::get('titulo');
            $DocDigital->asunto = Input::get('asunto');
            $DocDigital->cuerpo = $html;
//            $DocDigital->plantilla_doc_id = Input::get('plantilla');
            //$DocDigital->area_id = Auth::user()->area_id;

            if(Input::has('chk_todasareas') && Input::get('chk_todasareas') == 'allgesub'){
                $DocDigital->envio_total = 1;
            }else{
                $DocDigital->envio_total = 0;
            }

            $DocDigital->tipo_envio = Input::get('tipoenvio');
//            if(Input::get('tipoenvio')==3 or Input::get('tipoenvio')==5){
//                $DocDigital->persona_id = Auth::user()->id;    
//            }else{
//                $DocDigital->persona_id = $jefe[0]->id;                
//            }
            
            $DocDigital->usuario_updated_at = Auth::user()->id;
            $DocDigital->save();       
            $plantilla= PlantillaDocumento::find($DocDigital->plantilla_doc_id);
            if($DocDigital->id){

                // Update doc digital Temp
                $sql = "UPDATE doc_digital_temporal
                        SET asunto = '".$DocDigital->asunto."', envio_total='".$DocDigital->envio_total."', tipo_envio='".$DocDigital->tipo_envio."', usuario_updated_at='".$DocDigital->usuario_updated_at."'
                        WHERE id =  ".$DocDigital->id;
                DB::update($sql);
                // --

                $affectedRows = DocumentoDigitalArea::where('doc_digital_id', '=', $DocDigital->id)->get();
                foreach ($affectedRows as $docd) {
                    if($cambio_despues_de_proceso==1 AND $docd->estado==1){
                        $doc_dig_a_hi=new DocumentoDigitalAreaHistorico;
                        $doc_dig_a_hi->doc_digital_id=$doc_dig_hi->id;
                        $doc_dig_a_hi->persona_id=$docd->persona_id;
                        $doc_dig_a_hi->area_id=$docd->area_id;
                        $doc_dig_a_hi->rol_id= $docd->rol_id;
                        $doc_dig_a_hi->tipo= $docd->tipo;
                        $doc_dig_a_hi->estado= $docd->estado;
                        $doc_dig_a_hi->usuario_created_at = Auth::user()->id;
                        $doc_dig_a_hi->save();
                    }
                    $dd = DocumentoDigitalArea::find($docd->id);
                    $dd->estado = 0;
                    $dd->usuario_updated_at = Auth::user()->id;
                    $dd->save();
                }

                	$areas_envio = json_decode(Input::get('areasselect'));
                        if(count($areas_envio)>=10){
                            foreach ($areas_envio as $key => $value) {
                                $validacion=Area::find($value->area_id);
                                if($validacion->area_gestion_f==1){
                                    if(Input::get('tipoenvio')==2){
                                        if($value->area_id!=Auth::user()->area_id){
                                            $DocDigitalArea = new DocumentoDigitalArea();
                                            $DocDigitalArea->doc_digital_id = $DocDigital->id;
                                            $DocDigitalArea->persona_id = $value->persona_id;
                                            $DocDigitalArea->area_id = $value->area_id;
                                            $DocDigitalArea->tipo = $value->tipo;
                                            $DocDigitalArea->usuario_created_at = Auth::user()->id;
                                            $DocDigitalArea->save();
                                        }
                                    }else {
                                        $DocDigitalArea = new DocumentoDigitalArea();
                                        $DocDigitalArea->doc_digital_id = $DocDigital->id;
                                        $DocDigitalArea->persona_id = $value->persona_id;
                                        $DocDigitalArea->area_id = $value->area_id;
                                        $DocDigitalArea->tipo = $value->tipo;
                                        $DocDigitalArea->usuario_created_at = Auth::user()->id;
                                        $DocDigitalArea->save();
                                    }
                                }
                            }
                        }else {
                            foreach ($areas_envio as $key => $value) {
                                if((Input::get('tipoenvio')==1 or Input::get('tipoenvio')==5 or Input::get('tipoenvio')==6) AND $value->tipo!=2){
                                    foreach($value->persona_id as $personas){
                                        // Ingresar exoneracion por vacaciones
                                        if($plantilla->tipo_documento_id==110){
                                            
                                            if($cambio_despues_de_proceso==1){
                                                $doc_dig_hi->fecha_i_vacaciones=$DocDigital->fecha_i_vacaciones;
                                                $doc_dig_hi->fecha_f_vacaciones=$DocDigital->fecha_f_vacaciones;
                                                $doc_dig_hi->save();
                                            }
                                            $DocDigital->fecha_i_vacaciones = Input::get('fi_vacacion');
                                            $DocDigital->fecha_f_vacaciones = Input::get('ff_vacacion');
                                            $DocDigital->save();
                                            
                                            $persona = Persona::find($personas);
                                            $persona->fecha_ini_exonera = Input::get('fi_vacacion');
                                            $persona->fecha_fin_exonera = Input::get('ff_vacacion');
                                            $persona->usuario_updated_at = Auth::user()->id;
                                            $persona->save();


                                            /*disable old dates*/
                                            $OldDates = DB::table('persona_exoneracion')
                                                ->where('persona_id', '=', $personas)
                                                ->where('estado','=',1)
                                                ->get();
                                            if(count($OldDates)>0){
                                                foreach ($OldDates as $key => $valueE) {
                                                    $Changed = PersonaExoneracion::find($valueE->id);
                                                    $Changed->estado = 0;
                                                    $Changed->save();
                                                }                
                                            }
                                            /*end disable old dates*/

                                            $persona_exo = new PersonaExoneracion();
                                            $persona_exo->persona_id = $personas;
                                            $persona_exo->fecha_ini_exonera = $DocDigital->fecha_i_vacaciones.' 00:00:00';
                                            $persona_exo->fecha_fin_exonera = $DocDigital->fecha_f_vacaciones.' 00:00:00';
                                            $persona_exo->observacion =  'VACACIONES CON DOCUMENTO: '.$DocDigital->titulo;
                                            $persona_exo->doc_digital_id=$DocDigital->id;
                                            $persona_exo->estado=1;
                                            $persona_exo->usuario_created_at = Auth::user()->id;
                                            $persona_exo->save();

                                        }
                                        //*******************************************************/
                                        $DocDigitalArea = new DocumentoDigitalArea();
                                        $DocDigitalArea->doc_digital_id = $DocDigital->id;
                                        $DocDigitalArea->persona_id = $personas;
                                        $DocDigitalArea->area_id = $value->area_id;
                                        $DocDigitalArea->tipo = $value->tipo;
                                        $DocDigitalArea->usuario_created_at = Auth::user()->id;
                                        $DocDigitalArea->save();
                                    }
                                 
                                } else {
                                    $DocDigitalArea = new DocumentoDigitalArea();
                                    $DocDigitalArea->doc_digital_id = $DocDigital->id;
                                    $DocDigitalArea->persona_id = $value->persona_id;
                                    $DocDigitalArea->area_id = $value->area_id;
                                    $DocDigitalArea->tipo = $value->tipo;
                                    $DocDigitalArea->usuario_created_at = Auth::user()->id;
                                    $DocDigitalArea->save();
                                }

                            }
                        }                    
            }
            DB::commit();
            return Response::json(array('rst'=>1, 'msj'=>'Registro actualizado correctamente'));
        }
    }

    /**
     * Actualizar plantilla
     * POST /plantilla/editar
     */
    public function postCrear()
    {
        if ( Request::ajax() ) {
            $html = Input::get('word', '');
            $html=str_replace('http://proceso.munindependencia.pe/', '', $html);
            $jefe = DB::table('personas')
             ->where(         
                        function($query){
                            $query->where('area_id', '=', Auth::user()->area_id)
                            ->orwhereRaw('FIND_IN_SET(' . Auth::user()->area_id . ',area_responsable)');
                        }
                    )
                    ->whereIn('rol_id', array(8,9,6))
                    ->where('estado',1)
                    ->get();
            DB::beginTransaction();
            $DocDigital = new DocumentoDigital;
            $DocDigital->titulo = Input::get('titulofinal');
            $DocDigital->asunto = Input::get('asunto');
            $DocDigital->correlativo = Input::get('titulo');
            $DocDigital->cuerpo = $html;
            $DocDigital->plantilla_doc_id = Input::get('plantilla');
            $plantilla= PlantillaDocumento::find(Input::get('plantilla'));
            $DocDigital->area_id = $plantilla->area_id;
            if(Input::has('chk_todasareas') && Input::get('chk_todasareas') == 'allgesub'){
                $DocDigital->envio_total = 1;
            }else{
                $DocDigital->envio_total = 0;
            }

            $DocDigital->tipo_envio = Input::get('tipoenvio');
            if(Input::get('tipoenvio')==3 or Input::get('tipoenvio')==5 or Input::get('tipoenvio')==6){
                $DocDigital->persona_id = Auth::user()->id;    
            }else{
                $DocDigital->persona_id = $jefe[0]->id;                
            }

            $DocDigital->usuario_created_at = Auth::user()->id;

            $cantidad=true;
            $conteo=0;
            $conteoMax=10;
            $correlativoinicial=str_pad(Input::get('titulo'),6,"0",STR_PAD_LEFT);
            $correlativoaux=Input::get('titulo');
            while ( $cantidad==true ) {
                $cantidad=false;
                try {
                    $DocDigital->save();
                } catch (Exception $e) {
                    $d=explode("duplicate",strtolower($e));
                    if(count($d)>1){
                        $cantidad=true;
                        $DocDigital->correlativo++;
                        $correlativoaux=str_pad($DocDigital->correlativo,6,"0",STR_PAD_LEFT);
                        $DocDigital->titulo=str_replace($correlativoinicial,$correlativoaux,$DocDigital->titulo);
                    }
                    else{
                        $conteo=$conteoMax+1;
                    }
                }
                $conteo++;
                if($conteo==$conteoMax){
                    $cantidad=false;
                }
            }

            if($conteo==$conteoMax){
                DB::rollback();
                return Response::json(array('rst'=>3, 'msj'=>'Registro Inválido revise sus datos seleccionados','correlativo'=>$correlativoaux."|".$correlativoinicial));
            }
            elseif($conteo==$conteoMax+1){
                DB::rollback();
                return Response::json(array('rst'=>3, 'msj'=>'Registro Inválido o Existe un problema con el servidor, revise sus datos seleccionados','correlativo'=>$correlativoaux."|".$correlativoinicial));
            }

            if($DocDigital->id){
                    // --

                    $created=Input::get('fecha').' '.date ("h:i:s");     
                    $DocHistorial = new DocumentoFechaH;
                    $DocHistorial->documento_id = $DocDigital->id;
                    $DocHistorial->fecha_documento = $DocDigital->created_at;
                    $DocHistorial->comentario ='Inicio';
                    $DocHistorial->usuario_created_at = Auth::user()->id;
                    $DocHistorial->save();
                /*if(Input::get('tipoenvio')==3){
                    $DocDigitalArea = new DocumentoDigitalArea();
                    $DocDigitalArea->doc_digital_id = $DocDigital->id;
                    $DocDigitalArea->persona_id = $jefe[0]->id;
                    $DocDigitalArea->area_id =Auth::user()->area_id;
                    $DocDigitalArea->tipo = 1;
                    $DocDigitalArea->usuario_created_at = Auth::user()->id;
                    $DocDigitalArea->save();
                }else{*/
                	$areas_envio = json_decode(Input::get('areasselect'));
                        if(count($areas_envio)>=10){
                            foreach ($areas_envio as $key => $value) {
                                $validacion=Area::find($value->area_id);
                                if($validacion->area_gestion_f==1){
                                    if(Input::get('tipoenvio')==2){
                                        if($value->area_id!=Auth::user()->area_id){
                                            $DocDigitalArea = new DocumentoDigitalArea();
                                            $DocDigitalArea->doc_digital_id = $DocDigital->id;
                                            $DocDigitalArea->persona_id = $value->persona_id;
                                            $DocDigitalArea->area_id = $value->area_id;
                                            $DocDigitalArea->tipo = $value->tipo;
                                            $DocDigitalArea->usuario_created_at = Auth::user()->id;
                                            $DocDigitalArea->save();
                                        }
                                    }else {
                                        $DocDigitalArea = new DocumentoDigitalArea();
                                        $DocDigitalArea->doc_digital_id = $DocDigital->id;
                                        $DocDigitalArea->persona_id = $value->persona_id;
                                        $DocDigitalArea->area_id = $value->area_id;
                                        $DocDigitalArea->tipo = $value->tipo;
                                        $DocDigitalArea->usuario_created_at = Auth::user()->id;
                                        $DocDigitalArea->save();
                                    }
                                }
                            }
                        }else {
                            foreach ($areas_envio as $key => $value) {
                                if((Input::get('tipoenvio')==1 or Input::get('tipoenvio')==5 or Input::get('tipoenvio')==6) AND $value->tipo!=2){
                                    foreach($value->persona_id as $personas){
                                        // Ingresar exoneracion por vacaciones
                                        if($plantilla->tipo_documento_id==110){
                                            $DocDigital->fecha_i_vacaciones = Input::get('fi_vacacion');
                                            $DocDigital->fecha_f_vacaciones = Input::get('ff_vacacion');
                                            $DocDigital->save();
                                            
                                            $persona = Persona::find($personas);
                                            $persona->fecha_ini_exonera = Input::get('fi_vacacion');
                                            $persona->fecha_fin_exonera = Input::get('ff_vacacion');
                                            $persona->usuario_updated_at = Auth::user()->id;
                                            $persona->save();


                                            /*disable old dates*/
                                            $OldDates = DB::table('persona_exoneracion')
                                                ->where('persona_id', '=', $personas)
                                                ->where('estado','!=',0)
                                                ->get();
                                            if(count($OldDates)>0){
                                                foreach ($OldDates as $key => $valueE) {
                                                    $Changed = PersonaExoneracion::find($valueE->id);
                                                    $Changed->estado = 2;
                                                    $Changed->save();
                                                }                
                                            }
                                            /*end disable old dates*/

                                            $persona_exo = new PersonaExoneracion();
                                            $persona_exo->persona_id = $personas;
                                            $persona_exo->fecha_ini_exonera = $DocDigital->fecha_i_vacaciones.' 00:00:00';
                                            $persona_exo->fecha_fin_exonera = $DocDigital->fecha_f_vacaciones.' 00:00:00';
                                            $persona_exo->observacion =  'VACACIONES CON DOCUMENTO: '.$DocDigital->titulo;
                                            $persona_exo->doc_digital_id=$DocDigital->id;
                                            $persona_exo->estado=1;
                                            $persona_exo->usuario_created_at = Auth::user()->id;
                                            $persona_exo->save();

                                        }
                                        //*******************************************************/
                                        $DocDigitalArea = new DocumentoDigitalArea();
                                        $DocDigitalArea->doc_digital_id = $DocDigital->id;
                                        $DocDigitalArea->persona_id = $personas;
                                        $DocDigitalArea->area_id = $value->area_id;
                                        $DocDigitalArea->tipo = $value->tipo;
                                        $DocDigitalArea->usuario_created_at = Auth::user()->id;
                                        $DocDigitalArea->save();
                                    }
                                 
                                } else {
                                    $DocDigitalArea = new DocumentoDigitalArea();
                                    $DocDigitalArea->doc_digital_id = $DocDigital->id;
                                    $DocDigitalArea->persona_id = $value->persona_id;
                                    $DocDigitalArea->area_id = $value->area_id;
                                    $DocDigitalArea->tipo = $value->tipo;
                                    $DocDigitalArea->usuario_created_at = Auth::user()->id;
                                    $DocDigitalArea->save();
                                }

                            }
                        }
                //}
            }
            DB::commit();
            // Inserta doc digital Temp
                    $sql = 'INSERT INTO doc_digital_temporal (id,titulo,correlativo,asunto,plantilla_doc_id,area_id,persona_id,envio_total,tipo_envio,estado,
                                usuario_updated_at,updated_f_comentario,created_at,updated_at,usuario_created_at,usuario_f_updated_at)
                                SELECT id,titulo,correlativo,asunto,plantilla_doc_id,area_id,persona_id,envio_total,tipo_envio,estado,
                                usuario_updated_at,updated_f_comentario,created_at,updated_at,usuario_created_at,usuario_f_updated_at
                                FROM doc_digital dd
                                WHERE dd.id='.$DocDigital->id;
                    DB::insert($sql);
            return Response::json(array('rst'=>1, 'msj'=>'Su documento generado es: '.$DocDigital->titulo,'iddocdigital'=>$DocDigital->id));
        }
    }

    public function getVistauserqr($area_id,$id,$tamano,$tipo)
    {
        ini_set("max_execution_time", 300);
        ini_set('memory_limit','512M');        

        /*end get destinatario data*/
        $vistaprevia='';
        $size = 100; // TAMAÑO EN PX 
        $png = QrCode::format('png')->margin(0)->size($size)->generate("http://proceso.munindependencia.pe/documentodig/vistauserqrvalida/".$area_id."/".$id."/".$tamano."/".$tipo);
        $png = base64_encode($png);
        $png= "<img src='data:image/png;base64," . $png . "' width='100' height='100'>";
        //$meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');
        
        $oData=Persona::VerUsuarios($area_id, $id);
        
        $params = [
            'reporte'=>1,
            'nombres'=>$oData[0]->nombre,
            'apellidos'=>$oData[0]->paterno.' '.$oData[0]->materno,
            'area_id'=>$area_id,
            'area'=>$oData[0]->area,
            'estado'=>$oData[0]->estado,
            'dni'=>$oData[0]->dni,
            'imagen_dni'=>$oData[0]->imagen_dni,
            'resolucion'=>$oData[0]->resolucion,
            'numero'=>$oData[0]->cod_inspector,
            'tamano'=>$tamano,
            'vistaprevia'=>$vistaprevia,
            'imagen'=>$png
        ];

        $view = \View::make('admin.mantenimiento.templates.plantilla2', $params);
        $html = $view->render();

        $pdf = App::make('dompdf');
        $html = preg_replace('/>\s+</', '><', $html);
        $pdf->loadHTML($html);

        $pdf->setPaper('a'.$tamano)->setOrientation('portrait');

        return $pdf->stream();
        //\PDFF::loadHTML($html)->setPaper('a4')->setOrientation('landscape')->setWarnings(false)->stream();
    }

    public function getVistauserqrvalida($area_id,$id,$tamano,$tipo)
    {
        ini_set("max_execution_time", 300);
        ini_set('memory_limit','512M');        

        /*end get destinatario data*/
        
        $vistaprevia='Documento Vista Previa';
        
        $size = 100; // TAMAÑO EN PX 
        $png = QrCode::format('png')->margin(0)->size($size)->generate("http://proceso.munindependencia.pe/documentodig/vistauserqrvalida/".$area_id."/".$id."/".$tamano."/".$tipo);
        $png = base64_encode($png);
        $png= "<img src='data:image/png;base64," . $png . "' width='100' height='100'>";
        //$meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');
        
        $oData=Persona::VerUsuarios($area_id, $id);
        
        $params = [
            'reporte'=>3,
            'nombres'=>$oData[0]->nombre,
            'apellidos'=>$oData[0]->paterno.' '.$oData[0]->materno,
            'area_id'=>$area_id,
            'area'=>$oData[0]->area,
            'estado'=>$oData[0]->estado,
            'dni'=>$oData[0]->dni,
            'imagen_dni'=>$oData[0]->imagen_dni,
            'resolucion'=>$oData[0]->resolucion,
            'numero'=>$oData[0]->cod_inspector,
            'tamano'=>$tamano,
            'vistaprevia'=>$vistaprevia,
            'imagen'=>$png
        ];

        $view = \View::make('admin.mantenimiento.templates.plantilla2', $params);
        $html = $view->render();

        $pdf = App::make('dompdf');
        $html = preg_replace('/>\s+</', '><', $html);
        $pdf->loadHTML($html);

        $pdf->setPaper('a'.$tamano)->setOrientation('portrait');

        return $pdf->stream();
        //\PDFF::loadHTML($html)->setPaper('a4')->setOrientation('landscape')->setWarnings(false)->stream();
    }

    public function getVistatodosuserqr($area_id,$tamano,$tipo)
    {
        ini_set("max_execution_time", 300);
        ini_set('memory_limit','512M');

        $vistaprevia='';

        $oData=Persona::VerTodosUsuarios($area_id);
        
        $arr_data = array();
        foreach ($oData as $key => $val)
        {
            $data = array('nombre' => $val->nombre,
                            'apellidos' => $val->paterno.' '.$val->materno,
                            'area_id'=>$area_id,
                            'area' => $val->area,
                            'dni' => $val->dni,
                            'imagen_dni'=>$val->imagen_dni,
                            'imagen' => $this->ObtenerQR($area_id, $val->dni, $tamano, $tipo),
                            'resolucion'=>$val->resolucion,
                            'cod_inspector' => $val->cod_inspector);
            array_push($arr_data, $data);
        }
        /*
        echo '<pre>';
        print_r($arr_data) ;
        exit;
        */
        $params = [
            'reporte'=>2,
            'oData'=>$arr_data,            
            'tamano'=>$tamano,
            'vistaprevia'=>$vistaprevia
        ];

        $view = \View::make('admin.mantenimiento.templates.plantilla2', $params);
        $html = $view->render();

        $pdf = App::make('dompdf');
        $html = preg_replace('/>\s+</', '><', $html);
        $pdf->loadHTML($html);

        $pdf->setPaper('a'.$tamano)->setOrientation('landscape');

        return $pdf->stream();
        //\PDFF::loadHTML($html)->setPaper('a4')->setOrientation('landscape')->setWarnings(false)->stream();
    }

    public function ObtenerQR($area_id,$dni,$tamano,$tipo) {
      $size = 100;
      $png = QrCode::format('png')->margin(0)->size($size)->generate("http://proceso.munindependencia.pe/documentodig/vistauserqrvalida/".$area_id."/".$dni."/".$tamano."/".$tipo);
      $png = base64_encode($png);
      $png = "<img class='img-thumbnail' src='data:image/png;base64," . $png . "' width='100' height='100'>";
      
      return $png;
    }

    public function getVista($id,$tamano,$tipo)
    {
        ini_set("max_execution_time", 300);
        ini_set('memory_limit','512M');
        $DocumentoDigital = DocumentoDigital::find($id);
        $sql= "SELECT d.posicion,d.posicion_fecha
                FROM documentos d
                INNER JOIN plantilla_doc pd ON d.id=pd.tipo_documento_id
                WHERE pd.id=".$DocumentoDigital->plantilla_doc_id;
        $oData = DB::select($sql);
        
        if ($DocumentoDigital) {
            /*get remitente data*/
            $persona = Persona::find($DocumentoDigital->persona_id);
            $area = Area::find($DocumentoDigital->area_id);
            $rol= Rol::find($persona->rol_id);
              $remitente = $persona->nombre." ".$persona->paterno." ".$persona->materno." - <span style='font-size:11px'>".$area->nombre."</span>";
//            $remitente = $persona->nombre." ".$persona->paterno." ".$persona->materno." - <span style='font-size:11px'>(".$rol->nombre.") ".$area->nombre."</span>";
            /*end get remitente data */

            /*get destinatario data*/
            $copias = '';
            $destinatarios = '';
            if($DocumentoDigital->envio_total ==1){
                $copias = '';
                $destinatarios = 'Todas las Gerencias y Sub Gerencias';
            }else{
                $copias.= '';
                $destinatarios.= '';
                $DocDigitalArea = DocumentoDigitalArea::where('doc_digital_id', '=', $id)->where('estado', '=', 1)->get();
                $salto=9;
                $nb="&nbsp;";
                if($tamano==5){
                    $salto=6;
                    $nb="&nbsp;";
                }
                foreach($DocDigitalArea as $key => $value){
                    $persona2 = Persona::find($value->persona_id);
                    $area2 = Area::find($value->area_id);
                    $rol2= Rol::find($persona2->rol_id);
                    if($value->tipo ==1){
                        if($destinatarios!=""){
                            /*$destinatarios.="<br><span>&nbsp;&nbsp;".$nb."<span style='padding-left: ".$salto."em;'>";*/
                        }
                        else{
                            $destinatarios.="<span>";
                        }
                          $destinatarios.= $persona2->nombre.' '.$persona2->paterno.' '.$persona2->materno.' - </span><span style="font-size:11px">'.$area2->nombre.'</span><br>';
//                        $destinatarios.= $persona2->nombre.' '.$persona2->paterno.' '.$persona2->materno.' - </span><span style="font-size:11px">('.$rol2->nombre.') '.$area2->nombre.'</span><br>';
                    }else{
                        if($copias!=""){
                            /*$copias.="<br><span>&nbsp;&nbsp;".$nb."<span style='padding-left: ".$salto."em;'>";*/
                        }
                        else{
                            $copias.="<span>";
                        }
                          $copias.= $persona2->nombre.' '.$persona2->paterno.' '.$persona2->materno.' - </span><span style="font-size:11px">'.$area2->nombre.'</span><br>';
//                        $copias.= $persona2->nombre.' '.$persona2->paterno.' '.$persona2->materno.' - </span><span style="font-size:11px">('.$rol2->nombre.') '.$area2->nombre.'</span><br>';
                    }        
                }
                //$destinatarios.= '</ul>';    
                //$copias.= '</ul>';          
            }

            /*end get destinatario data*/
            if($tamano==4){
                $size=122;}
            else if($tamano==5){
                 $size=115;
            }
            
            $png = QrCode::format('png')->margin(0)->size($size)->generate("http://proceso.munindependencia.pe/documentodig/vista/".$id."/".$tamano."/0");
            $png = base64_encode($png);
            $png= "<img src='data:image/png;base64," . $png . "'>";
            $meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');
            
            $fechabase=$DocumentoDigital->created_at;
            $fecha=explode(' ', $fechabase);
            $fechaa=explode('-', $fecha[0]);
            
            $cabecera=1;
            
            if($DocumentoDigital->tipo_envio==4 || $DocumentoDigital->tipo_envio==7){
                $cabecera=null;
            }
//            if($DocumentoDigital->tipo_envio==4 AND $DocumentoDigital->area_id==12){
//                $DocumentoDigital->area_id=1;
//            }
//            if($DocumentoDigital->tipo_envio==4 AND $DocumentoDigital->area_id==44){
//                $DocumentoDigital->area_id=1;
//            }
            if($tipo==0){
                $vistaprevia='Documento Vista Previa';}
            else if($tipo==1){
                 $vistaprevia='';
            }
            $documenttittle= $DocumentoDigital->titulo;
            if(strlen($documenttittle)>=59 AND $tamano==4){
                $maximo= substr($documenttittle, 0,59);
                $min=substr($documenttittle, 59);
                $parte1="";
                $parte2="";
                $dmaximo= explode("-",$maximo);
                for ($i=0; $i < count($dmaximo); $i++) { 
                    if( count($dmaximo)>($i+1) ){
                        $parte1.=$dmaximo[$i]."-";
                    }
                    else{
                        $parte2=$dmaximo[$i].$min;
                    }
                }
                $documenttittle=$parte1."<br><br>".$parte2;
            }
            else if(strlen($documenttittle)>=47 AND $tamano==5){
                $maximo= substr($documenttittle, 0,47);
                $min=substr($documenttittle, 47);
                $parte1="";
                $parte2="";
                $dmaximo= explode("-",$maximo);
                for ($i=0; $i < count($dmaximo); $i++) { 
                    if( count($dmaximo)>($i+1) ){
                        $parte1.=$dmaximo[$i]."-";
                    }
                    else{
                        $parte2=$dmaximo[$i].$min;
                    }
                }
                $documenttittle=$parte1."<br><br>".$parte2;
            }
            else{
                $documenttittle= $DocumentoDigital->titulo;
            }
            $params = [
                'tamano'=>$tamano,
                'posicion'=>$oData[0]->posicion,
                'posicion_fecha'=>$oData[0]->posicion_fecha,
                'tipo_envio'=>$DocumentoDigital->tipo_envio,
                'titulo' => $documenttittle,
                'vistaprevia'=>$vistaprevia,
                'area' => $DocumentoDigital->area_id,
                'asunto' => $DocumentoDigital->asunto,
                'conCabecera' => $cabecera,
                'contenido' => $DocumentoDigital->cuerpo,
                'fecha' => 'Independencia, '.$fechaa[2].' de '.$meses[$fechaa[1]*1].' del '.$fechaa[0],
                'remitente' => $remitente,
                'destinatario' => $destinatarios,
                'imagen'=>$png,
                'anio'=>$fechaa[0],
            ];  
            if($copias != '' && $copias != '<ul></ul>'){ 
                $params['copias'] = $copias;                
            }
            $params = $params;
            
            $view = \View::make('admin.mantenimiento.templates.plantilla1', $params);
            $html = $view->render();

            $pdf = App::make('dompdf');
            $html = preg_replace('/>\s+</', '><', $html);
            $pdf->loadHTML($html);

            $pdf->setPaper('a'.$tamano)->setOrientation('portrait');

            return $pdf->stream();
            //\PDFF::loadHTML($html)->setPaper('a4')->setOrientation('landscape')->setWarnings(false)->stream();
        }

    }

    public function getVistaprevia($id,$tamano=4,$tipo=1)
   {   $tipo=1;
       ini_set("max_execution_time", 300);
       ini_set('memory_limit','512M');
       $DocumentoDigital = DocumentoDigital::find($id);
       $sql= "SELECT d.posicion,d.posicion_fecha
               FROM documentos d
               INNER JOIN plantilla_doc pd ON d.id=pd.tipo_documento_id
               WHERE pd.id=".$DocumentoDigital->plantilla_doc_id;
       $oData = DB::select($sql);
       
       if ($DocumentoDigital) {
           /*get remitente data*/
           $persona = Persona::find($DocumentoDigital->persona_id);
           $area = Area::find($DocumentoDigital->area_id);
//           $rol= Rol::find($persona->rol_id);
               $remitente = $persona->nombre." ".$persona->paterno." ".$persona->materno." - <span style='font-size:11px'> ".$area->nombre."</span>";
//             $remitente = $persona->nombre." ".$persona->paterno." ".$persona->materno." - <span style='font-size:11px'>(".$rol->nombre.") ".$area->nombre."</span>";
             /*end get remitente data */
 
             /*get destinatario data*/
             $copias = '';
             $destinatarios = '';
             if($DocumentoDigital->envio_total ==1){
                 $copias = '';
                 $destinatarios = 'Todas las Gerencias y Sub Gerencias';
             }else{
                 $copias.= '';
                 $destinatarios.= '';
                 $DocDigitalArea = DocumentoDigitalArea::where('doc_digital_id', '=', $id)->where('estado', '=', 1)->get();
                 $salto=9;
                 $nb="&nbsp;";
 
               foreach($DocDigitalArea as $key => $value){
                   $persona2 = Persona::find($value->persona_id);
                   $area2 = Area::find($value->area_id);
//                   $rol2= Rol::find($persona2->rol_id);
                   if($value->tipo ==1){
                       if($destinatarios!=""){
                           /*$destinatarios.="<br><span>&nbsp;&nbsp;".$nb."<span style='padding-left: ".$salto."em;'>";*/
                       }
                       else{
                           $destinatarios.="<span>";
                       }
                         $destinatarios.= $persona2->nombre.' '.$persona2->paterno.' '.$persona2->materno.' - </span><span style="font-size:11px">'.$area2->nombre.'</span><br>';
//                       $destinatarios.= $persona2->nombre.' '.$persona2->paterno.' '.$persona2->materno.' - </span><span style="font-size:11px">('.$rol2->nombre.') '.$area2->nombre.'</span><br>';
                   }else{
                       if($copias!=""){
                           /*$copias.="<br><span>&nbsp;&nbsp;".$nb."<span style='padding-left: ".$salto."em;'>";*/
                       }
                       else{
                           $copias.="<span>";
                       }
                       $copias.= $persona2->nombre.' '.$persona2->paterno.' '.$persona2->materno.' - </span><span style="font-size:11px"> '.$area2->nombre.'</span><br>';
//                       $copias.= $persona2->nombre.' '.$persona2->paterno.' '.$persona2->materno.' - </span><span style="font-size:11px">('.$rol2->nombre.') '.$area2->nombre.'</span><br>';
                   }        
               }
               //$destinatarios.= '</ul>';    
               //$copias.= '</ul>';          
           }
 
           /*end get destinatario data*/
           if($tamano==4){
               $size=122;}
           else if($tamano==5){
                $size=115;
           }
           
           $png = QrCode::format('png')->margin(0)->size($size)->generate("http://proceso.munindependencia.pe/documentodig/vista/".$id."/".$tamano."/0");
           $png = base64_encode($png);
           $png= "<img src='data:image/png;base64," . $png . "'>";
           $meses=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre');
           
           $fechabase=$DocumentoDigital->created_at;
           $fecha=explode(' ', $fechabase);
           $fechaa=explode('-', $fecha[0]);
           
           $cabecera=1;
           
           if($DocumentoDigital->tipo_envio==4 || $DocumentoDigital->tipo_envio==7){
               $cabecera=null;
           }
 //            if($DocumentoDigital->tipo_envio==4 AND $DocumentoDigital->area_id==12){
 //                $DocumentoDigital->area_id=1;
 //            }
 //            if($DocumentoDigital->tipo_envio==4 AND $DocumentoDigital->area_id==44){
 //                $DocumentoDigital->area_id=1;
 //            }
 
           $vistaprevia='';
           
           $documenttittle= $DocumentoDigital->titulo;
           if(strlen($documenttittle)>60 AND $tamano==4){
               $dd=explode("-",$documenttittle);
               $documenttittle='';
               if( strlen( $dd[0] )<=40 ){
                   for ($i=0; $i < count($dd) ; $i++) { 
                       if( ($i+2)==count($dd) ){
                           $documenttittle.="<br><br>".$dd[$i]."-".$dd[$i+1];
                           $i++;
                       }
                       else{
                           $documenttittle.=$dd[$i]."-";
                       }
                   }
               }
               else{
                   for ($i=0; $i < count($dd) ; $i++) { 
                       if( ($i+3)==count($dd) ){
                           $documenttittle.="<br><br>".$dd[$i]."-".$dd[$i+1]."-".$dd[$i+2];
                           $i++;$i++;
                       }
                       else{
                           $documenttittle.=$dd[$i]."-";
                       }
                   }
               }
           }
           else if(strlen($documenttittle)>50 AND $tamano==5){
               $dd=explode("-",$documenttittle);
               $documenttittle='';
               if( strlen( $dd[0] )<=40 ){
                   for ($i=0; $i < count($dd) ; $i++) { 
                       if( ($i+3)==count($dd) ){
                           $documenttittle.="<br><br>".$dd[$i]."-".$dd[$i+1]."-".$dd[$i+2];
                           $i++;
                       }
                       else{
                           $documenttittle.=$dd[$i]."-";
                       }
                   }
               }
               else{
                   for ($i=0; $i < count($dd) ; $i++) { 
                       if( ($i+4)==count($dd) ){
                           $documenttittle.="<br><br>".$dd[$i]."-".$dd[$i+1]."-".$dd[$i+2]."-".$dd[$i+3];
                           $i++;$i++;
                       }
                       else{
                           $documenttittle.=$dd[$i]."-";
                       }
                   }
               }
           }
           else{
               $documenttittle= $DocumentoDigital->titulo;
           }
           $params = [
               'tamano'=>$tamano,
               'posicion'=>$oData[0]->posicion,
               'posicion_fecha'=>$oData[0]->posicion_fecha,
               'tipo_envio'=>$DocumentoDigital->tipo_envio,
               'titulo' => $documenttittle,
               'vistaprevia'=>$vistaprevia,
               'area' => $DocumentoDigital->area_id,
               'asunto' => $DocumentoDigital->asunto,
               'conCabecera' => $cabecera,
               'contenido' => $DocumentoDigital->cuerpo,
               'fecha' => 'Independencia, '.$fechaa[2].' de '.$meses[$fechaa[1]*1].' del '.$fechaa[0],
               'remitente' => $remitente,
               'destinatario' => $destinatarios,
               'imagen'=>$png,
           ];  
           if($copias != '' && $copias != '<ul></ul>'){ 
               $params['copias'] = $copias;                
           }
           $params = $params;
           
           $view = \View::make('admin.mantenimiento.templates.plantilla1', $params);
           $html = $view->render();
 
           $pdf = App::make('dompdf');
           $html = preg_replace('/>\s+</', '><', $html);
           $pdf->loadHTML($html);

           $pdf->setPaper('a'.$tamano)->setOrientation('portrait');
 
           return $pdf->stream();
           //\PDFF::loadHTML($html)->setPaper('a4')->setOrientation('landscape')->setWarnings(false)->stream();
       }
 
   }
    
    function dataEjemploPlantilla() {
        return [
            'titulo' => '(EJEMPLO) MEMORANDUM CIRCULAR N 016-2016-SG/MDC',
            'remitente' => 'Nombre de Encargado <br>Nombre de Gerencia y/o Subgerencia',
            'destinatario' => 'Nombre a quien va dirigido <br>Nombre de Gerencia y/o Subgerencia',
            'asunto' => 'Titulo, <i>Ejemplo:</i> Invitación a la Inaguración del Palacio Municipal',
            'fecha' => 'Lima,'.date('d').' de '.date('F').' del '.date('Y'),
        ];
    }


    public function postDocdigital()
    {
        //si la peticion es ajax
        if ( Request::ajax() ) {
            //$cargar         = TablaRelacion::getPlataforma();

                $array=array();
                $array['where']='';$array['usuario']=Auth::user()->id;
                $array['limit']='';$array['order']='';
                $array['having']='HAVING ruta=0 AND rutadetallev=0';

                if(Input::has('idtipo') AND Input::get('idtipo')!=''){
                    if(Input::get('idtipo')==1){
                        $array['having']="HAVING ruta=".Input::get('idtipo')." OR rutadetallev=".Input::get('idtipo')."";                    
                    }else{
                         $array['having']="HAVING ruta=".Input::get('idtipo')." AND rutadetallev=".Input::get('idtipo').""; 
                    }
                }
                
             /*   if (Input::has('draw')) {
                    if (Input::has('order')) {
                        $inorder=Input::get('order');
                        $incolumns=Input::get('columns');
                        $array['order']=  ' ORDER BY '.
                                          $incolumns[ $inorder[0]['column'] ]['name'].' '.
                                          $inorder[0]['dir'];
                    }

                    $array['limit']=' LIMIT '.Input::get('start').','.Input::get('length');
                    $aParametro["draw"]=Input::get('draw');
                }*/
                /************************************************************/

                if( Input::has('titulo') AND Input::get('titulo')!='' ){
                    $array['where'].=" AND dd.titulo LIKE '%".Input::get('titulo')."%' ";
                }

                if( Input::has('asunto') AND Input::get('asunto')!='' ){
                    $array['where'].=" AND dd.asunto LIKE '%".Input::get('asunto')."%' ";
                }

                if( Input::has('plantilla') AND Input::get('plantilla')!='' ){
                    $array['where'].=" AND pd.descripcion LIKE '%".Input::get('plantilla')."%' ";
                }
/*

                if( Input::has("area") ){
                    $usuario=Input::get("usuario");
                    if( trim( $usuario )!='' ){
                        $array['where'].=" AND CONCAT_WS(p.nombre,p.paterno,p.materno) LIKE '%".$usuario."%' ";
                    }
                }

                if( Input::has("fecha_tramite") ){
                    $fecha_t=Input::get("fecha_tramite");
                    if( trim( $fecha_inicio )!='' ){
                        $array['where'].=" AND DATE(tr.fecha_tramite)='".$fecha_t."' ";
                    }
                }*/

                $array['order']=" ORDER BY ruta DESC,rutadetallev DESC ";

                $cant  = DocumentoDigital::getDocdigitalCount( $array );
                $aData = DocumentoDigital::getDocdigital( $array );

                $aParametro['rst'] = 1;
                $aParametro["recordsTotal"]=$cant;
                $aParametro["recordsFiltered"]=$cant;
                $aParametro['data'] = $aData;
                $aParametro['msj'] = "No hay registros aún";
                return Response::json($aParametro);
        }
    }

	/**
	 * Display a listing of the resource.
	 * GET /documentodigital
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /documentodigital/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /documentodigital
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /documentodigital/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /documentodigital/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /documentodigital/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /documentodigital/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
        
        public function postBuscardocumentofinal(){
            
        if ( Request::ajax() ) {  
            $array["where"]='';
            
            if( Input::has("titulo") AND Input::get('titulo')!='' ){
                $array["where"].='(1=1';
                 $titulo=explode(" ",trim(Input::get('titulo')));
                    for($i=0; $i<count($titulo); $i++){
                       $array['where'].=" AND ddt.titulo LIKE '%".$titulo[$i]."%' ";
                    }
                 $array["where"].=') OR ';    
            }
            
            
            if( Input::has("fecha") AND Input::get('fecha')!='' ){
                $array["where"].=' (';
                 list($fechaIni,$fechaFin) = explode(" - ", Input::get('fecha'));
                 $array['where'].= "DATE(ddt.created_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
                 $array["where"].=')';
            }
            
            
            $documento_digital = DocumentoDigital::postBuscarDocumentoFinal($array);
            return Response::json(array('rst'=>1,'datos'=>$documento_digital));
        }
    }
    
            public function postMostrarhistoricodocumento(){
            
        if ( Request::ajax() ) {  
            $documento_digital = DocumentoDigital::postMostrarHistoricoDocumento();
            return Response::json(array('rst'=>1,'datos'=>$documento_digital));
        }
    }

}
