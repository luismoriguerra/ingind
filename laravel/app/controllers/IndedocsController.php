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
        $array = array(
            'incidencias' => array(
                array(
                    "codigo" => "4474",
                    "fecha" => "18-10-2017",
                    "hora" => "09:29",
                    "clasificacion" => "ARROJO DE DESMONTE Y OTROS OBJETOS",
                    "direccion" => "Huanacaure 127, Cercado de Lima 15332, Perú,",
                    "foto" => "fotoed/4474.jpg",
                    "contenido" => "Desmonte personas animales.",
                ),
                array(
                    "codigo" => "4475",
                    "fecha" => "18-10-2017",
                    "hora" => "09:36",
                    "clasificacion" => "MATERIAL DE CONSTRUCCION",
                    "direccion" => "Tupac Amaru 66, Lima 15311, Perú,null",
                    "foto" => "fotoed/4475.jpg",
                    "contenido" => "Materiales de construccion...",
                ),
            )
        );
        $result = json_decode(json_encode($array));

        foreach ($result->incidencias as $k) {
            $fecha = explode('-', $k->fecha);
            $incidencia = new CargaIncidencia;
            $incidencia->codigo = $k->codigo;
            $incidencia->fecha = $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0] . ' ' . $k->hora . ':00';
            $incidencia->clasificacion = $k->clasificacion;
            $incidencia->direccion = $k->direccion;
            $incidencia->foto = $k->foto;
            $incidencia->contenido = $k->contenido;
            $incidencia->save();

            //PROCESO DESMONTE 5383
            $rutaFlujo = RutaFlujo::find(5383);

            $tablarelacion = new TablaRelacion;
            $tablarelacion->software_id = 1;
            $tablarelacion->id_union = 'INCIDENCIAS - N° ' . str_pad($incidencia->codigo, 6, '0', STR_PAD_LEFT) . ' - 2017';
            $tablarelacion->sumilla = $k->contenido.' - '.$k->clasificacion;
            $tablarelacion->estado = 1;
            $tablarelacion->fecha_tramite = $incidencia->fecha;
            $tablarelacion->usuario_created_at = Auth::user()->id;
            $tablarelacion->save();
                            
            $ruta = new Ruta;
            $ruta['tabla_relacion_id'] = $tablarelacion->id;
            $ruta['fecha_inicio'] = $incidencia->fecha;
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
                $rutaDetalle = new RutaDetalle;
                $rutaDetalle['ruta_id'] = $ruta->id;
                $rutaDetalle['area_id'] = $rd->area_id;
                $rutaDetalle['tiempo_id'] = $rd->tiempo_id;
                $rutaDetalle['dtiempo'] = $rd->dtiempo;
                $rutaDetalle['norden'] = $rd->norden;
                $rutaDetalle['estado_ruta'] = $rd->estado_ruta;

                $rutaDetalle['usuario_created_at'] = Auth::user()->id;
                $rutaDetalle->save();

                if ($rutaDetalle->norden == 1) {
                    $rutaDetalle['fecha_inicio'] = date('Y-m-d H:i:s');
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
        }
        
        return Response::json(array('rst' => 1));
    }

}
