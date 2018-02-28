<?php

class IndedocsController extends \BaseController {

    public function postListadocumentosindedocs() {

        $area = Auth::user()->area_id;
        //$area=32;
        $AreaIntera = AreaInterna::where('area_id', '=', $area)->first();
        $tipoDocumento = Input::get('tipo_documento');
        $fecha = Input::get('fechaI');
        $buscar = array('-');
        $reemplazar = array('.');
        $fechaActualizada = str_replace($buscar, $reemplazar, $fecha);

        $retorno = array(
            'rst' => 1
        );

        $url = 'https://www.muniindependencia.gob.pe/repgmgm/index.php?opcion=documento&area=' . $AreaIntera->area_id_indedocs . '&tipo=' . $tipoDocumento . '&fecha=' . $fechaActualizada;
        $curl_options = array(
            //reemplazar url 
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_ENCODING => 'gzip,deflate',
        );

        $ch = curl_init();
        curl_setopt_array($ch, $curl_options);
        $output = curl_exec($ch);
        curl_close($ch);

        $r = json_decode(utf8_encode($output), true);

        $html = "";


        $n = 1;
        if (isset($r["documento"]) AND count($r["documento"]) > 0) {
            foreach ($r["documento"] as $rr) {
                $buscar = array(' - ');
                $reemplazar = array('-');
                $valor = str_replace($buscar, $reemplazar, $rr["Docu_cabecera"]);
                $html .= "<tr>";
                $html .= "<td>" . $n . "</td>";
                $html .= "<td>" . $valor . "</td>";
                $html .= '<td> <a class="btn btn-success" onClick="cargarNroDoc(\'' . $valor . '\',\'' . $rr["Documento_id"] . '\')" data-toggle="modal" data-target="#indedocsModal">
                                                    <i class="fa fa-check fa-lg"></i>
                                                </a></td>';
                $html .= "</tr>";
                $n++;
            }
        }
        if (!isset($r["documento"]) AND count($r["documento"]) < 1) {
            $html .= "<h3 style='color:blue'><center>IndeDocs no disponible. Usar el Lápiz para digitar manualmente el Documento</center></h3>";
        }
        $retorno["data"] = $html;

        return Response::json($retorno);
    }

    public function postListatipodocumentosindedocs() {
        $retorno = array(
            'rst' => 1
        );

        $url = 'https://www.muniindependencia.gob.pe/repgmgm/index.php?opcion=tipos';
        $curl_options = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_ENCODING => 'gzip,deflate',
        );

        $ch = curl_init();
        curl_setopt_array($ch, $curl_options);
        $output = curl_exec($ch);
        curl_close($ch);

        $r = json_decode(utf8_encode($output), true);

        $html = "";


        $n = 1;
        if (isset($r["tipos"]) AND count($r["tipos"]) > 0) {
            foreach ($r["tipos"] as $rr) {
                $html .= "<option value='" . $rr['documentotipo_id'] . "'>" . $rr['documentotipo_descripcion'] . "</option>";
            }
        }

        $retorno["data"] = $html;

        return Response::json($retorno);
    }

    public function postConsulta() {

        $actividad = Persona::RequestActividades();
        return Response::json(array('rst' => 1, 'datos' => $actividad));
    }

    public function postIncidencia() {
        
        $res = file_get_contents("http://www.muniindependencia.gob.pe/ceteco/index.php?opcion=incidencias&fecha=".date('Ymd'));
        $result = json_decode(utf8_encode($res));
       /*
        $array = array(
            'incidencias' => array(
                array(
                    "codigo" => "4474",
                    "fecha" => "18-10-2018",
                    "hora" => "09:29",
                    "clasificacion" => "ARROJO DE DESMONTE Y OTROS OBJETOS",
                    "direccion" => "Huanacaure 127, Cercado de Lima 15332, Perú,",
                    // "foto" => "fotoed/4474.jpg",
                    "foto" => "http://www.muniindependencia.gob.pe/sicmovil/fotoed/18201.jpg",
                    "contenido" => "Desmonte personas animales.",
                ),
                array(
                    "codigo" => "4475",
                    "fecha" => "18-10-2018",
                    "hora" => "09:36",
                    "clasificacion" => "MATERIAL DE CONSTRUCCION",
                    "direccion" => "Tupac Amaru 66, Lima 15311, Perú,null",
                    // "foto" => "fotoed/4475.jpg",
                    "foto" => "http://www.muniindependencia.gob.pe/sicmovil/fotoed/18205.jpg",
                    "contenido" => "Materiales de construccion...",
                ),
            )
        );
        $result = json_decode(json_encode($array));
        */
        foreach ($result->incidencias as $k) {
            $busqueda= CargaIncidencia::where('codigo',$k->codigo)->first();
            
            if(count($busqueda)==0){
                //  DB::beginTransaction();
                    $fecha = explode('-', $k->fecha);

                    //PROCESO DESMONTE 5383
                    $rutaFlujo = RutaFlujo::find(5383);

                    $tablarelacion = new TablaRelacion;
                    $tablarelacion->software_id = 1;
                    $tablarelacion->id_union = 'COMUNICADO EDUCATIVO - Nº ' . str_pad($k->codigo, 6, '0', STR_PAD_LEFT) . ' - '.$fecha[2].' - MDI';
                    $tablarelacion->sumilla = $k->contenido.' - '.$k->clasificacion;
                    $tablarelacion->estado = 1;
                    $tablarelacion->fecha_tramite = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0] . ' ' . $k->hora . ':00';
                    $tablarelacion->usuario_created_at = Auth::user()->id;
                    $tablarelacion->save();

                    $ruta = new Ruta;
                    $ruta['tabla_relacion_id'] = $tablarelacion->id;
                    $ruta['fecha_inicio'] = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0] . ' ' . $k->hora . ':00';
                    $ruta['ruta_flujo_id'] = $rutaFlujo->id;
                    $ruta['flujo_id'] = $rutaFlujo->flujo_id;
                    $ruta['persona_id'] = $rutaFlujo->persona_id;
                    $ruta['area_id'] = $rutaFlujo->area_id;
                    $ruta['usuario_created_at'] = Auth::user()->id;
                    $ruta->save();

                    /*             * **********Agregado de referidos************ */
        //            $referido = new Referido;
        //            $referido['ruta_id'] = $ruta->id;
        //            $referido['tabla_relacion_id'] = $tablarelacion->id;
        //            $referido['tipo'] = 0;
        //            $referido['referido'] = $tablarelacion->id_union;
        //            $referido['fecha_hora_referido'] = $tablarelacion->created_at;
        //            $referido['usuario_referido'] = $tablarelacion->usuario_created_at;
        //            $referido['usuario_created_at'] =Auth::user()->id;
        //            $referido->save();

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
                        $rutaDetalle['dtiempo'] = $rd->dtiempo;
                        $rutaDetalle['norden'] = $cero.$rd->norden;
                        $rutaDetalle['estado_ruta'] = $rd->estado_ruta;

                        $rutaDetalle['usuario_created_at'] = Auth::user()->id;
                        $rutaDetalle->save();

                        if ($rutaDetalle->norden == 1) {
                            $rutaDetalle['fecha_inicio'] = date('Y-m-d H:i:s');
                            $rutaDetalle['archivo'] = @$k->foto;
                            $rutaDetalle->save();
                        }

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
                                $rutaDetalleVerbo->save();
                            }
                        }
                    }
                    $insertMicro="INSERT INTO rutas_detalle_micro (ruta_flujo_id,ruta_id,norden,usuario_created_at)
                                  SELECT rfdm.ruta_flujo_id2,".$ruta->id.",IF(rfdm.norden<10,CONCAT('0',norden),norden) AS norden,".Auth::user()->id."
                                  FROM rutas_flujo_detalle_micro rfdm
                                  WHERE rfdm.ruta_flujo_id=".$rutaFlujo->id." AND rfdm.estado=1";

                    DB::insert($insertMicro);
                    
                    $incidencia = new CargaIncidencia;
                    $incidencia->codigo = $k->codigo;
                    $incidencia->fecha = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0] . ' ' . $k->hora . ':00';
                    $incidencia->clasificacion = $k->clasificacion;
                    $incidencia->direccion = $k->direccion;
                    $incidencia->foto = @$k->foto;
                    $incidencia->contenido = $k->contenido;
                    $incidencia->ruta_id=$ruta->id;
                    $incidencia->save();
        //          DB::commit();
            }
        }
        return Response::json(array('rst' => 1));
    }


    public function postRequerimientos()
    {
        //$res = file_get_contents("http://www.muniindependencia.gob.pe/ceteco/index.php?opcion=incidencias&fecha=".date('Ymd'));
        //$result = json_decode(utf8_encode($res));
        /*
        fecha=19/02/2018 (DECHA DE EMISION)
        &AREADESTINO=Gerencia de Administracion y Finanzas
        &AREADESTFLUJO=26 (MIO) FLUJO_ID
        
        &REQNUM=23
        &REQANNO=2018
        &AREADSIGA=030002 (AREA DE ORIGEN)
        &AREADESTSIGA=040000 (AREA DESTINO)
            
        &AREAFLUJO=14 (MIO) AREA ORIGEN
        &NOMDOC=INFORME - N° 000037 - 2018 - SGTIC-GMGM-MDI
        &IDDOC=137607 (MIO)

        &OBSERVACION=ok
        */
        $array = array(
            'requerimientos' => array(
                array(
                    "fecha" => "19/02/2018",
                    "AREADESTINO" => "Gerencia de Administracion y Finanzas",
                    "AREADESTFLUJO" => "26",
                    
                    "REQNUM" => "23",
                    "REQANNO" => "2018",
                    "AREADSIGA" => "030002",
                    "AREADESTSIGA" => "040000",
                    
                    "AREAFLUJO" => "14",
                    "NOMDOC" => "INFORME - N° 000037 - 2018 - SGTIC-GMGM-MDI",
                    "IDDOC" => "137607",
                    "IDDOC" => "ok"
                )
            )
        );
        $result = json_decode(json_encode($array));

        foreach ($result->requerimientos as $k) {
            
            // AREA
            $area = Area::find($k->AREAFLUJO);


            break;
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
        return Response::json(array('rst' => 1));
    }
}
