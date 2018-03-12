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
        
        //$res = file_get_contents("http://www.muniindependencia.gob.pe/ceteco/index.php?opcion=incidencias&fecha=".date('Ymd'));
        $res = file_get_contents("http://www.muniindependencia.gob.pe/ceteco/index.php?opcion=incidencias&fecha=20180310");
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
        $select = "SELECT MAX(correlativo) as correlativo
                    FROM doc_digital
                        WHERE titulo LIKE '%COMUNICADO EDUCATIVO%'
                    ORDER BY correlativo;";
        $doc_digital = DB::select($select);
        $correlativo = $doc_digital[0]->correlativo;
        
        $cod_correlativo = 0;

        foreach ($result->incidencias as $k) {
            $busqueda= CargaIncidencia::where('codigo', $k->codigo)->first();
            
            if(count($busqueda)==0)
            {
                $codigo_vp = 0;
                $fecha = explode('-', $k->fecha);

                // Carga en la taabla "carga_incidencias"
                $incidencia = new CargaIncidencia;
                $incidencia->codigo = $k->codigo;
                $incidencia->fecha = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0] . ' ' . $k->hora . ':00';
                $incidencia->clasificacion = $k->clasificacion;
                $incidencia->direccion = $k->direccion;
                $incidencia->foto = @$k->foto;
                $incidencia->contenido = $k->contenido;
                $incidencia->tipo = $k->tipo;
                $incidencia->viapredio = $k->viapredio;
                //$incidencia->ruta_id=$ruta->id;
                $incidencia->save();

                if($k->tipo == 'DESMONTE')
                {                    
                    //  DB::beginTransaction();
                    //PROCESO DESMONTE 5383
                    $rutaFlujo = RutaFlujo::find(5383);

                    $tablarelacion = new TablaRelacion;
                    $tablarelacion->software_id = 1;

                    // $k->codigo
                    if($k->viapredio == 'VIA') {                    
                        $select = "SELECT MAX(serie) as codigo_vp FROM carga_incidencias
                                        WHERE tipo = 'DESMONTE' AND viapredio = 'VIA';";
                        $doc_digital_dvp = DB::select($select);
                        $codigo_vp = $doc_digital_dvp[0]->codigo_vp + 1;
                        $tablarelacion->id_union = 'DESMONTE VIA PUBLICA - Nº ' . str_pad($codigo_vp, 6, '0', STR_PAD_LEFT) . ' - '.$fecha[2].' - MDI';
                        $cod_correlativo = $codigo_vp;
                    }
                    else {
                        $correlativo++;
                        $tablarelacion->id_union = 'COMUNICADO EDUCATIVO - Nº ' . str_pad($correlativo, 6, '0', STR_PAD_LEFT) . ' - '.$fecha[2].' - MDI';
                        $cod_correlativo = $correlativo;
                    }
                    
                    $tablarelacion->sumilla = $k->clasificacion.'</br>'.$k->contenido.'</br>'.$k->direccion;
                    $tablarelacion->estado = 1;
                    $tablarelacion->fecha_tramite = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0] . ' ' . $k->hora . ':00';
                    $tablarelacion->usuario_created_at = Auth::user()->id;
                    $tablarelacion->save();
                }
                else if($k->tipo == 'MATERIALES') // PROCESO MATERIAL DE CONSTRUCCION
                {
                    $rutaFlujo = RutaFlujo::find(5541);

                    $tablarelacion = new TablaRelacion;
                    $tablarelacion->software_id = 1;

                    if($k->viapredio == 'VIA') {                    
                        $select = "SELECT MAX(serie) as codigo_vp FROM carga_incidencias
                                        WHERE tipo = 'MATERIALES' AND viapredio = 'VIA';";
                        $doc_digital_dvp = DB::select($select);
                        $codigo_vp = $doc_digital_dvp[0]->codigo_vp + 1;
                        $tablarelacion->id_union = 'MATERIAL DE CONSTRUCCION VIA PUBLICA - Nº ' . str_pad($codigo_vp, 6, '0', STR_PAD_LEFT) . ' - '.$fecha[2].' - MDI';
                        $cod_correlativo = $codigo_vp;
                    }
                    else {
                        $correlativo++;
                        $tablarelacion->id_union = 'COMUNICADO EDUCATIVO - Nº ' . str_pad($correlativo, 6, '0', STR_PAD_LEFT) . ' - '.$fecha[2].' - MDI';
                        $cod_correlativo = $correlativo;
                    }

                    $tablarelacion->sumilla = $k->clasificacion.'</br>'.$k->contenido.'</br>'.$k->direccion;
                    $tablarelacion->estado = 1;
                    $tablarelacion->fecha_tramite = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0] . ' ' . $k->hora . ':00';
                    $tablarelacion->usuario_created_at = Auth::user()->id;
                    $tablarelacion->save();
                }
                else if($k->tipo == 'VEHICULO') // PROCESO VEHICULOS ABANDONADOS
                {
                    $rutaFlujo = RutaFlujo::find(5560);

                    $tablarelacion = new TablaRelacion;
                    $tablarelacion->software_id = 1;
                    
                    if($k->viapredio == 'VIA') {                    
                        $select = "SELECT MAX(serie) as codigo_vp FROM carga_incidencias
                                        WHERE tipo = 'VEHICULO' AND viapredio = 'VIA';";
                        $doc_digital_dvp = DB::select($select);
                        $codigo_vp = $doc_digital_dvp[0]->codigo_vp + 1;
                        $tablarelacion->id_union = 'VEHICULOS ABANDONADOS VIA PUBLICA - Nº ' . str_pad($codigo_vp, 6, '0', STR_PAD_LEFT) . ' - '.$fecha[2].' - MDI';
                        $cod_correlativo = $codigo_vp;
                    }                        
                    else {
                        $correlativo++;
                        $tablarelacion->id_union = 'COMUNICADO EDUCATIVO - Nº ' . str_pad($correlativo, 6, '0', STR_PAD_LEFT) . ' - '.$fecha[2].' - MDI';
                        $cod_correlativo = $correlativo;
                    }

                    $tablarelacion->sumilla = $k->clasificacion.'</br>'.$k->contenido.'</br>'.$k->direccion;
                    $tablarelacion->estado = 1;
                    $tablarelacion->fecha_tramite = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0] . ' ' . $k->hora . ':00';
                    $tablarelacion->usuario_created_at = Auth::user()->id;
                    $tablarelacion->save();
                }
                else if($k->tipo == 'BASURA') // PROCESO RESIDUOS SOLIDOS
                {                    
                    $rutaFlujo = RutaFlujo::find(5540);

                    $tablarelacion = new TablaRelacion;
                    $tablarelacion->software_id = 1;
                    
                    if($k->viapredio == 'VIA') {                    
                        $select = "SELECT MAX(serie) as codigo_vp FROM carga_incidencias
                                        WHERE tipo = 'BASURA' AND viapredio = 'VIA';";
                        $doc_digital_dvp = DB::select($select);
                        $codigo_vp = $doc_digital_dvp[0]->codigo_vp + 1;
                        $tablarelacion->id_union = 'RESIDUOS SOLIDOS VIA PUBLICA - Nº ' . str_pad($codigo_vp, 6, '0', STR_PAD_LEFT) . ' - '.$fecha[2].' - MDI';
                        $cod_correlativo = $codigo_vp;
                    }
                    else {
                        $correlativo++;
                        $tablarelacion->id_union = 'COMUNICADO EDUCATIVO - Nº ' . str_pad($correlativo, 6, '0', STR_PAD_LEFT) . ' - '.$fecha[2].' - MDI';
                        $cod_correlativo = $correlativo;
                    }

                    $tablarelacion->sumilla = $k->clasificacion.'</br>'.$k->contenido.'</br>'.$k->direccion;
                    $tablarelacion->estado = 1;
                    $tablarelacion->fecha_tramite = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0] . ' ' . $k->hora . ':00';
                    $tablarelacion->usuario_created_at = Auth::user()->id;
                    $tablarelacion->save();
                }
                else if($k->tipo == 'PODA') // PROCESO PODA DE JARDINES
                {
                    $rutaFlujo = RutaFlujo::find(5542);

                    $tablarelacion = new TablaRelacion;
                    $tablarelacion->software_id = 1;
                    
                    if($k->viapredio == 'VIA') {                    
                        $select = "SELECT MAX(serie) as codigo_vp FROM carga_incidencias
                                        WHERE tipo = 'PODA' AND viapredio = 'VIA';";
                        $doc_digital_dvp = DB::select($select);
                        $codigo_vp = $doc_digital_dvp[0]->codigo_vp + 1;
                        $tablarelacion->id_union = 'PODA DE JARDINES VIA PUBLICA - Nº ' . str_pad($codigo_vp, 6, '0', STR_PAD_LEFT) . ' - '.$fecha[2].' - MDI';
                        $cod_correlativo = $codigo_vp;
                    }
                    else {
                        $correlativo++;
                        $tablarelacion->id_union = 'COMUNICADO EDUCATIVO - Nº ' . str_pad($correlativo, 6, '0', STR_PAD_LEFT) . ' - '.$fecha[2].' - MDI';
                        $cod_correlativo = $correlativo;
                    }

                    $tablarelacion->sumilla = $k->clasificacion.'</br>'.$k->contenido.'</br>'.$k->direccion;
                    $tablarelacion->estado = 1;
                    $tablarelacion->fecha_tramite = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0] . ' ' . $k->hora . ':00';
                    $tablarelacion->usuario_created_at = Auth::user()->id;
                    $tablarelacion->save();
                }

                    $ruta = new Ruta;
                    $ruta['tabla_relacion_id'] = $tablarelacion->id;
                    $ruta['fecha_inicio'] = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0] . ' ' . $k->hora . ':00';
                    $ruta['ruta_flujo_id'] = $rutaFlujo->id;
                    $ruta['flujo_id'] = $rutaFlujo->flujo_id; //Actualizar la tabla "rutas_flujo"
                    $ruta['persona_id'] = $rutaFlujo->persona_id;
                    $ruta['area_id'] = $rutaFlujo->area_id;
                    $ruta['usuario_created_at'] = Auth::user()->id;
                    $ruta->save();

                    /* ***********Agregado de referidos************ */
                    // $referido = new Referido;
                    // $referido['ruta_id'] = $ruta->id;
                    // $referido['tabla_relacion_id'] = $tablarelacion->id;
                    // $referido['tipo'] = 0;
                    // $referido['referido'] = $tablarelacion->id_union;
                    // $referido['fecha_hora_referido'] = $tablarelacion->created_at;
                    // $referido['usuario_referido'] = $tablarelacion->usuario_created_at;
                    // $referido['usuario_created_at'] =Auth::user()->id;
                    // $referido->save();

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
                    
                    // Actualiza tabla "carga_incidencias"
                    $sql = "UPDATE carga_incidencias ci
                                    SET ci.serie = ".$cod_correlativo.",
                                        ci.ruta_id = ".$ruta->id."
                                        WHERE codigo = '".$k->codigo."';";
                    DB::update($sql);
                    // DB::commit();
                //}
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
                    "fecha" => "28/02/2018",
                    "AREADESTINO" => "Gerencia de Administracion y Finanzas",
                    "AREADESTFLUJO" => "26",
                    
                    "REQNUM" => "908",
                    "REQANNO" => "2018",
                    "AREADSIGA" => "030002",
                    "AREADESTSIGA" => "040000",

                    "AREAFLUJO" => "94",
                    "NOMDOC" => "",
                    "IDDOC" => "",
                    "IDDOC" => ""
                )
            )
        );
        $result = json_decode(json_encode($array));

        $dtiempo_final = '2018-02-28 '.date('H:i:s');

        foreach ($result->requerimientos as $k) {            

            $area_origen = Area::find($k->AREAFLUJO);
            $selecttr="SELECT tr.id, tr.id_union, tr.fecha_tramite
                        FROM tablas_relacion tr 
                        INNER JOIN rutas r ON r.tabla_relacion_id=tr.id AND r.estado=1
                        WHERE tr.id_union LIKE '%".$k->REQNUM."%'
                            AND tr.id_union LIKE '%".$k->REQANNO."%'
                            AND tr.id_union LIKE '%".$area_origen->nemonico."%'
                            AND tr.id_union LIKE '%REQ%'
                            AND tr.estado=1;";
            /**/

            $tabla_relacion = DB::select($selecttr);
            // -- 
            $selecttr="SELECT *
                        FROM rutas
                            WHERE tabla_relacion_id = ".$tabla_relacion[0]->id;
            $rutas = DB::select($selecttr);

            // -- 
            $selectrd="SELECT *
                        FROM rutas_detalle
                            WHERE ruta_id = ".$rutas[0]->id."
                                //AND area_id = ".$k->AREAFLUJO."
                                AND dtiempo_final IS NULL
                                AND fecha_inicio IS NOT NULL
                                AND estado = 1";
            $ruta_detalle = DB::select($selectrd);

            // --
            if($ruta_detalle[0]->area_id == 94) // Es AREA Logistica = 29
            {
                $rutaDetalle = RutaDetalle::find($ruta_detalle[0]->id);
                $rutaDetalle['fecha_inicio'] = $ruta_detalle[0]->fecha_inicio;
                $rutaDetalle['dtiempo_final'] = $dtiempo_final;
                $rutaDetalle['tipo_respuesta_id'] = 1;
                $rutaDetalle['tipo_respuesta_detalle_id'] = 1;
                $rutaDetalle['observacion'] = '';
                $rutaDetalle->save();

                $rutaDetalleVerbo = RutaDetalleVerbo::where('ruta_detalle_id', '=', $rutaDetalle->id)
                                                    ->where('estado', '=', 1)->get();
                if(count($rutaDetalleVerbo) > 0) {
                    foreach ($rutaDetalleVerbo as $r) {
                        $rdv = RutaDetalleVerbo::find($r->id);
                        if ($k->IDDOC != '') {
                            $rdv['documento'] = $k->AREAFLUJO;
                            $rdv['doc_digital_id'] = $k->IDDOC;
                        }                    
                        $rdv['finalizo'] = 1;
                        $rdv['observacion'] = 'AUTOMATICO';
                        $rdv['usuario_created_at'] = 1272;
                        $rdv['usuario_updated_at'] = 1272;
                        $rdv['updated_at'] = date('Y-m-d H:i:s');
                        $rdv->save();
                    }
                }
            }    
        }

        //$param_data = array('respuesta' => 'Proceso ejecutado Satisfactorio');
        //$objArr = $this->curl("ruta.php", $param_data);
        $return_response = $thi->response(200,"success","Proceso ejecutado satisfactoriamente");

        // Creación de un archivo JSON para dar respuesta al cliente
          $uploadFolder = 'txt/api';
          $nombre_archivo = "respuesta.json";
          $file = $uploadFolder . '/' . $nombre_archivo;
          unlink($file);
          if($archivo = fopen($file, "a"))
          {
            fwrite($archivo, $return_response);
            fclose($archivo);
          }
        // --

        return Response::json(array('rst' => 1));
    }

    /*
    public function curl($url, $data=array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }
    */

    public function response($code=200, $status="", $message="")
    {
        if( !empty($status) && !empty($message) )
        {
            $response = array(
                        "status" => $status ,
                        "message"=>$message,
                        "server" => $this->getIPCliente()
                    );
            return json_encode($response, JSON_PRETTY_PRINT);
        }
    }
}