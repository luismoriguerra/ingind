<?php
class CargarController extends BaseController
{

    public function postAsignacionsistradocvalida()
    {
        ini_set('memory_limit','512M');
        set_time_limit(600);
        if (isset($_FILES['carga']) and $_FILES['carga']['size'] > 0) {

            $uploadFolder = 'txt/asignacion';
            
            if ( !is_dir($uploadFolder) ) {
                mkdir($uploadFolder);
            }


            $nombreArchivo = explode(".",$_FILES['carga']['name']);
            $tmpArchivo = $_FILES['carga']['tmp_name'];
            $archivoNuevo = $nombreArchivo[0]."_u".Auth::user()->id."_".date("Ymd_his")."." . $nombreArchivo[1];
            $file = $uploadFolder . '/' . $archivoNuevo;

            //@unlink($file);

            $m="Ocurrio un error al subir el archivo. No pudo guardarse.";
            if (!move_uploaded_file($tmpArchivo, $file)) {
                return Response::json(
                    array(
                        'upload' => FALSE,
                        'rst'    => '2',
                        'msj'    => $m,
                        'error'  => $_FILES['archivo'],
                    )
                );
            }

            $array=array();
            $arrayExist=array();

            //$file=file('C:\\wamp\\www\\ingind\\public\\txt\\asignacion\\'.$archivoNuevo);
            //$file=file('/home/m1ndepen/public_html/procesosmuni/public/txt/asignacion/'.$archivoNuevo);
            
            $file=file('/var/www/ingind/public/txt/asignacion/'.$archivoNuevo);

            $tipoTramite['01']='EN TRAMITE';
            $tipoTramite['02']='ANULADO';
            $tipoTramite['03']='RESUELTO';
            $tipoTramite['04']='ARCHIVADO';
            $tipoTramite['05']='CUSTODIA';
            $tipoTramite['06']='1º RESOLUCION ( ATENDIDO )';
            $tipoTramite['07']='2º RESOLUCIÓN ( RESOL. RECONSD.)';
            $tipoTramite['08']='3º RESOLUCION ( RESOL. APELACION )';
            $tipoTramite['09']='4º RESOLUCION ( ABANDONO )';
            $tipoTramite['10']='5º RESOLUCION ( RECONS. ABANDNO )';
            $tipoTramite['11']='6º RESOLUCION ( APELAC. ABANDONO )';
            $tipoTramite['12']='FORMULARIOS';
            $tipoTramite['13']='DOCUMENTACION INTERNA';
            $tipoTramite['14']='ENVIAR EL ANEXO AL EXPEDIENTE ORIGINAL';
            $tipoTramite['15']='ATENDIDO';
            $tipoTramite['16']='EN PROCESO';
                for($i=0; $i < count($file); $i++) {
                    $detfile=explode("\t",$file[$i]);

                    for ($j=0; $j < count($detfile); $j++) { 
                        $buscar=array(chr(13).chr(10), "\r\n", "\n","�", "\r","\n\n","\xEF","\xBB","\xBF");
                        $reemplazar="";
                        $detfile[$j]=trim(str_replace($buscar,$reemplazar,$detfile[$j]));
                        $array[$i][$j]=$detfile[$j];
                    }

                    //if($i>0){
                        $exist=TablaRelacion::where('id_union','=',$detfile[0])
                                            ->where('estado','=','1')
                                            ->get();

                        $ainterna=AreaInterna::find($detfile[12]);
                        $tdoc=explode("-",$detfile[0]);

                        if( count($ainterna)==0 AND count($exist)>0 ){
                            $sql="  SELECT rd.area_id
                                    FROM rutas r
                                    INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1
                                    where rd.norden=2
                                    AND r.estado=1 
                                    AND r.tabla_relacion_id='".$exist[0]->id."'";
                            $areaId=DB::select($sql);

                            $ainterna=AreaInterna::where('area_id','=',$areaId[0]->area_id)
                                                    ->where('estado','=','1')
                                                    ->firts();
                        }

                        if( count($ainterna)==0 ){
                            $arrayExist[]=$detfile[0]."; No cuenta con Ruta revise cod area de plataforma ingresado.";
                        }
                        else{

                            if( count($exist)!=1 ){
                                if( count($exist)==0 ){
                                    $arrayExist[]=$detfile[0]."; Tramite no existe. Estado: ".$tipoTramite[$detfile[15]]." Cant: ".$detfile[16];
                                }
                                elseif( count($exist)>1 ){
                                    $arrayExist[]=$detfile[0]."; Tramite ya existe. Estado: ".$tipoTramite[$detfile[15]]." Cant: ".$detfile[16];
                                }
                            }
                            elseif( $detfile[16]<=2 ){
                                $arrayExist[]=$detfile[0]."; Tramite no fué atendido por Sistradoc. Estado: ".$tipoTramite[$detfile[15]]." Cant:".$detfile[16];
                            }
                            else{

                                $tipoPersona=TipoSolicitante::where('nombre_relacion','=',$detfile[2])->first();
                                if( count($tipoPersona)==0 ){
                                    $arrayExist[]=$detfile[0]."; TipoPersona no existe. ".$tipoTramite[$detfile[15]]." Cant: ".$detfile[16];
                                }
                                else{
                                    DB::beginTransaction();

                                    $tr = new TablaRelacion;
                                    $tr['tipo_persona']=$tipoPersona->id;

                                    if( $detfile[3]!="" ){ // razon social
                                        $tr['razon_social']=$detfile[3];
                                    }

                                    if( $detfile[4]!="" ){ // ruc
                                        $tr['ruc']=$detfile[4];
                                    }

                                    if( $detfile[5]!="" ){ // dni
                                        $tr['dni']=$detfile[5];
                                    }

                                    if( $detfile[6]!="" ){ // paterno
                                        $tr['paterno']=$detfile[6];
                                    }

                                    if( $detfile[7]!="" ){ // materno
                                        $tr['materno']=$detfile[7];
                                    }

                                    if( $detfile[8]!="" ){ // nombre
                                        $tr['nombre']=$detfile[8];
                                    }
                                    
                                    $fecha_inicio=date("Y-m-d 08:00:00");

                                    $tr['software_id']= '1';
                                    $tr['id_union']= $detfile[0];
                                    $tr['fecha_tramite']=$fecha_inicio;
                                    $tr['sumilla']=$detfile[9];
                                    $tr['email']=$detfile[10];
                                    $tr['telefono']=$detfile[11];
                                    $tr['usuario_created_at'] = 1272;
                                    $tr->save();

                                    $flujo_interno=trim($detfile[13]);
                                    $rf=array('');

                                    $rf=RutaFlujo::where( 'flujo_id','=',$ainterna->flujo_id )
                                                ->where('estado','=','1')
                                                ->first();

                                    $rutaFlujo=RutaFlujo::find($rf->id);
                                    

                                    $ruta= new Ruta;
                                    $ruta['tabla_relacion_id']=$tr->id;
                                    $ruta['fecha_inicio']= $fecha_inicio;
                                    $ruta['ruta_flujo_id']=$rutaFlujo->id;
                                    $ruta['flujo_id']=$rutaFlujo->flujo_id;
                                    $ruta['persona_id']=$rutaFlujo->persona_id;
                                    $ruta['area_id']=$rutaFlujo->area_id;
                                    $ruta['usuario_created_at']= 1272;
                                    $ruta->save();

                                    /************Agregado de referidos*************/
                                    $referido=new Referido;
                                    $referido['ruta_id']=$ruta->id;
                                    $referido['tabla_relacion_id']=$tr->id;
                                    $referido['tipo']=0;
                                    $referido['referido']=$tr->id_union;
                                    $referido['fecha_hora_referido']=$tr->created_at;
                                    $referido['usuario_referido']=$tr->usuario_created_at;
                                    $referido['usuario_created_at']=1272;
                                    $referido->save();
                                    /**********************************************/

                                    $qrutaDetalle=DB::table('rutas_flujo_detalle')
                                        ->where('ruta_flujo_id', '=', $rutaFlujo->id)
                                        ->where('estado', '=', '1')
                                        ->orderBy('norden','ASC')
                                        ->get();
                                        $validaactivar=0;
                                    foreach($qrutaDetalle as $rd){
                                        $rutaDetalle = new RutaDetalle;
                                        $rutaDetalle['ruta_id']=$ruta->id;
                                        $rutaDetalle['area_id']=$rd->area_id;
                                        $rutaDetalle['tiempo_id']=$rd->tiempo_id;
                                        $rutaDetalle['dtiempo']=$rd->dtiempo;
                                        $rutaDetalle['norden']=$rd->norden;
                                        $rutaDetalle['estado_ruta']=$rd->estado_ruta;

                                                $rutaDetalle['dtiempo_final']=date('Y-m-d 08:00:00');
                                                $rutaDetalle['tipo_respuesta_id']=2;
                                                $rutaDetalle['tipo_respuesta_detalle_id']=1;
                                                $rutaDetalle['observacion']="";
                                                $rutaDetalle['usuario_updated_at']=1272;
                                                $rutaDetalle['updated_at']=date('Y-m-d 08:00:00');
                                                $rutaDetalle['fecha_inicio']=$fecha_inicio;

                                        $rutaDetalle['usuario_created_at']= 1272;
                                        $rutaDetalle->save();

                                        $qrutaDetalleVerbo=DB::table('rutas_flujo_detalle_verbo')
                                                        ->where('ruta_flujo_detalle_id', '=', $rd->id)
                                                        ->where('estado', '=', '1')
                                                        ->orderBy('orden', 'ASC')
                                                        ->get();
                                        if(count($qrutaDetalleVerbo)>0){
                                            foreach ($qrutaDetalleVerbo as $rdv) {
                                                $rutaDetalleVerbo = new RutaDetalleVerbo;
                                                $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                                                $rutaDetalleVerbo['nombre']= $rdv->nombre;
                                                $rutaDetalleVerbo['condicion']= $rdv->condicion;
                                                $rutaDetalleVerbo['rol_id']= $rdv->rol_id;
                                                $rutaDetalleVerbo['verbo_id']= $rdv->verbo_id;
                                                $rutaDetalleVerbo['documento_id']= $rdv->documento_id;
                                                $rutaDetalleVerbo['orden']= $rdv->orden;
                                                $rutaDetalleVerbo['usuario_created_at']= 1272;

                                                    $rutaDetalleVerbo['usuario_updated_at']= 1272;
                                                    $rutaDetalleVerbo['updated_at']= date('Y-m-d 08:00:00');
                                                    $rutaDetalleVerbo['finalizo']=1;

                                                $rutaDetalleVerbo->save();
                                            }
                                        }
                                    }
                                    DB::commit();
                                }
                            } //es codigo nuevo
                        }// valida si tiene flujo id
                    //}// Apartir del 2 registro
                }// for del file

            return Response::json(
                array(
                    'rst'       => '1',
                    'msj'       => 'Archivo procesado correctamente',
                    'file'    => $archivoNuevo,
                    'upload'    => TRUE, 
                    'data'      => $array,
                    'existe'    => $arrayExist
                )
            );
        }
    }

    public function postAsignacion()
    {
        ini_set('memory_limit','512M');
        if (isset($_FILES['carga']) and $_FILES['carga']['size'] > 0) {

            $uploadFolder = 'txt/asignacion';
            
            if ( !is_dir($uploadFolder) ) {
                mkdir($uploadFolder);
            }


            $nombreArchivo = explode(".",$_FILES['carga']['name']);
            $tmpArchivo = $_FILES['carga']['tmp_name'];
            $archivoNuevo = $nombreArchivo[0]."_u".Auth::user()->id."_".date("Ymd_his")."." . $nombreArchivo[1];
            $file = $uploadFolder . '/' . $archivoNuevo;

            //@unlink($file);

            $m="Ocurrio un error al subir el archivo. No pudo guardarse.";
            if (!move_uploaded_file($tmpArchivo, $file)) {
                return Response::json(
                    array(
                        'upload' => FALSE,
                        'rst'    => '2',
                        'msj'    => $m,
                        'error'  => $_FILES['archivo'],
                    )
                );
            }

            $array=array();
            $arrayExist=array();

            //$file=file('C:\\wamp\\www\\ingind\\public\\txt\\asignacion\\'.$archivoNuevo);
            //$file=file('/home/m1ndepen/public_html/procesosmuni/public/txt/asignacion/'.$archivoNuevo);
            
            $file=file('/var/www/ingind/public/txt/asignacion/'.$archivoNuevo);
                for($i=0; $i < count($file); $i++) {
                    $detfile=explode("\t",$file[$i]);

                    for ($j=0; $j < count($detfile); $j++) { 
                        $buscar=array(chr(13).chr(10), "\r\n", "\n","�", "\r","\n\n","\xEF","\xBB","\xBF");
                        $reemplazar="";
                        $detfile[$j]=trim(str_replace($buscar,$reemplazar,$detfile[$j]));
                        $array[$i][$j]=$detfile[$j];
                    }

                    //if($i>0){
                        $ainterna=AreaInterna::find($detfile[12]);
                        $tdoc=explode("-",$detfile[0]);

                        if( count($ainterna)==0 ){
                            $arrayExist[]=$detfile[0]."; No cuenta con Ruta revise cod area de plataforma ingresado.";
                        }
                        elseif( strtoupper(substr($ainterna->nombre,0,3))=='SUB' AND 
                                ( strtoupper($tdoc[0])=='DS' OR strtoupper($tdoc[0])=='EX' ) AND
                                $ainterna->id!=20 AND $ainterna->id!=23 AND $ainterna->id!=29 AND 
                                $ainterna->id!=36 AND $ainterna->id!=40
                        )
                        {
                            $arrayExist[]=$detfile[0]."; No se puede ingresar el tipo de tramite DS ni EX para sub gerencias a excepción de logistica";
                        }
                        else{
                        $exist=TablaRelacion::where('id_union','=',$detfile[0])
                                            ->where('estado','=','1')
                                            ->get();

                            if( count($exist)>0 ){
                                $arrayExist[]=$detfile[0]."; Tramite ya existe";
                            }
                            else{

                                $tipoPersona=TipoSolicitante::where('nombre_relacion','=',$detfile[2])->first();
                                if( count($tipoPersona)==0 ){
                                    $arrayExist[]=$detfile[0]."; TipoPersona no existe";
                                }
                                else{
                                    DB::beginTransaction();

                                    $tr = new TablaRelacion;
                                    $tr['tipo_persona']=$tipoPersona->id;

                                    if( $detfile[3]!="" ){ // razon social
                                        $tr['razon_social']=$detfile[3];
                                    }

                                    if( $detfile[4]!="" ){ // ruc
                                        $tr['ruc']=$detfile[4];
                                    }

                                    if( $detfile[5]!="" ){ // dni
                                        $tr['dni']=$detfile[5];
                                    }

                                    if( $detfile[6]!="" ){ // paterno
                                        $tr['paterno']=$detfile[6];
                                    }

                                    if( $detfile[7]!="" ){ // materno
                                        $tr['materno']=$detfile[7];
                                    }

                                    if( $detfile[8]!="" ){ // nombre
                                        $tr['nombre']=$detfile[8];
                                    }
                                    
                                    $fecha_inicio=date("Y-m-d H:i:s");

                                    $tr['software_id']= '1';
                                    $tr['id_union']= $detfile[0];
                                    $tr['fecha_tramite']=$fecha_inicio;
                                    $tr['sumilla']=$detfile[9];
                                    $tr['email']=$detfile[10];
                                    $tr['telefono']=$detfile[11];
                                    $tr['usuario_created_at'] = Auth::user()->id;
                                    $tr->save();

                                    $flujo_interno=trim($detfile[13]);
                                    $rf=array('');
                                    if( $flujo_interno!='' ){
                                        $fi=FlujoInterno::where( 'flujo_id_interno','=',($flujo_interno*1) )
                                                        ->where('estado','=','1')
                                                        ->first();
                                        if( count($fi)>0 ){
                                            if( trim($fi->flujo_id)!='' ){
                                                $rf=RutaFlujo::where( 'flujo_id','=',$fi->flujo_id )
                                                            ->where('estado','=','1')
                                                            ->first();
                                            }
                                            elseif( trim($fi->nombre)!='' ){
                                                $sql="  SELECT rf.*
                                                        FROM rutas_flujo rf
                                                        INNER JOIN flujos f ON rf.flujo_id=f.id AND f.estado=1
                                                        WHERE f.nombre LIKE '".$fi->nombre."%'
                                                        AND FIND_IN_SET(SUBSTRING_INDEX(f.nombre,' ',-1),(SELECT nemonico FROM areas WHERE id=".$ainterna->area_id."))>0";
                                                $qsql=DB::select($sql);
                                                $rf=$qsql[0];
                                            }
                                        }
                                        else{
                                            $rf=RutaFlujo::where( 'flujo_id','=',$ainterna->flujo_id )
                                                        ->where('estado','=','1')
                                                        ->first();
                                        }

                                    }
                                    else{
                                        $rf=RutaFlujo::where( 'flujo_id','=',$ainterna->flujo_id )
                                                    ->where('estado','=','1')
                                                    ->first();
                                    }

                                    $rutaFlujo=RutaFlujo::find($rf->id);
                                    

                                    $ruta= new Ruta;
                                    $ruta['tabla_relacion_id']=$tr->id;
                                    $ruta['fecha_inicio']= $fecha_inicio;
                                    $ruta['ruta_flujo_id']=$rutaFlujo->id;
                                    $ruta['flujo_id']=$rutaFlujo->flujo_id;
                                    $ruta['persona_id']=$rutaFlujo->persona_id;
                                    $ruta['area_id']=$rutaFlujo->area_id;
                                    $ruta['usuario_created_at']= Auth::user()->id;
                                    $ruta->save();

                                    /************Agregado de referidos*************/
                                    $referido=new Referido;
                                    $referido['ruta_id']=$ruta->id;
                                    $referido['tabla_relacion_id']=$tr->id;
                                    $referido['tipo']=0;
                                    $referido['referido']=$tr->id_union;
                                    $referido['fecha_hora_referido']=$tr->created_at;
                                    $referido['usuario_referido']=$tr->usuario_created_at;
                                    $referido['usuario_created_at']=Auth::user()->id;
                                    $referido->save();
                                    /**********************************************/

                                    $qrutaDetalle=DB::table('rutas_flujo_detalle')
                                        ->where('ruta_flujo_id', '=', $rutaFlujo->id)
                                        ->where('estado', '=', '1')
                                        ->orderBy('norden','ASC')
                                        ->get();
                                        $validaactivar=0;
                                    foreach($qrutaDetalle as $rd){
                                        $rutaDetalle = new RutaDetalle;
                                        $rutaDetalle['ruta_id']=$ruta->id;
                                        $rutaDetalle['area_id']=$rd->area_id;
                                        $rutaDetalle['tiempo_id']=$rd->tiempo_id;
                                        $rutaDetalle['dtiempo']=$rd->dtiempo;
                                        $rutaDetalle['norden']=$rd->norden;
                                        $rutaDetalle['estado_ruta']=$rd->estado_ruta;
                                        if($rd->norden==1 or $rd->norden==2 or ($rd->norden>1 and $validaactivar==0 and $rd->estado_ruta==2) ){
                                            if($rd->norden==1){
                                                $rutaDetalle['dtiempo_final']=$fecha_inicio;
                                                $rutaDetalle['tipo_respuesta_id']=2;
                                                $rutaDetalle['tipo_respuesta_detalle_id']=1;
                                                $rutaDetalle['observacion']="";
                                                $rutaDetalle['usuario_updated_at']=Auth::user()->id;
                                                $rutaDetalle['updated_at']=$fecha_inicio;
                                            }
                                            $rutaDetalle['fecha_inicio']=$fecha_inicio;
                                        }
                                        else{
                                            $validaactivar=1;
                                        }
                                        $rutaDetalle['usuario_created_at']= Auth::user()->id;
                                        $rutaDetalle->save();

                                        $qrutaDetalleVerbo=DB::table('rutas_flujo_detalle_verbo')
                                                        ->where('ruta_flujo_detalle_id', '=', $rd->id)
                                                        ->where('estado', '=', '1')
                                                        ->orderBy('orden', 'ASC')
                                                        ->get();
                                        if(count($qrutaDetalleVerbo)>0){
                                            foreach ($qrutaDetalleVerbo as $rdv) {
                                                $rutaDetalleVerbo = new RutaDetalleVerbo;
                                                $rutaDetalleVerbo['ruta_detalle_id']= $rutaDetalle->id;
                                                $rutaDetalleVerbo['nombre']= $rdv->nombre;
                                                $rutaDetalleVerbo['condicion']= $rdv->condicion;
                                                $rutaDetalleVerbo['rol_id']= $rdv->rol_id;
                                                $rutaDetalleVerbo['verbo_id']= $rdv->verbo_id;
                                                $rutaDetalleVerbo['documento_id']= $rdv->documento_id;
                                                $rutaDetalleVerbo['orden']= $rdv->orden;
                                                $rutaDetalleVerbo['usuario_created_at']= Auth::user()->id;

                                                if($rd->norden==1){
                                                    $rutaDetalleVerbo['usuario_updated_at']= Auth::user()->id;
                                                    $rutaDetalleVerbo['updated_at']= $fecha_inicio;
                                                    $rutaDetalleVerbo['finalizo']=1;
                                                }

                                                $rutaDetalleVerbo->save();
                                            }
                                        }
                                    }
                                    DB::commit();
                                }
                            } //es codigo nuevo
                        }// valida si tiene flujo id
                    //}// Apartir del 2 registro
                }// for del file

            return Response::json(
                array(
                    'rst'       => '1',
                    'msj'       => 'Archivo procesado correctamente',
                    'file'    => $archivoNuevo,
                    'upload'    => TRUE, 
                    'data'      => $array,
                    'existe'    => $arrayExist
                )
            );
        }
    }

}
