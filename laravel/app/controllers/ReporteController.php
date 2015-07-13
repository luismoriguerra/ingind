<?php

class ReporteController extends BaseController
{
  /**
   * bandeja de tramite, devuelve la consulta de tramites que se asignan 
   * a una determinada area que pertenece el usuario
   */
   public function postBandejatramite()
   {
        $rst=VisualizacionTramite::BandejaTramites();
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst
            )
        );
   }
    /**
     * 
     */
    public function postTramitexfecha()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        //$fechaIni = Input::get('fechaIni');
        $fechaFin = $fechaFin.' 23:59:59';
        $rutaFlujo =    DB::table('rutas_flujo AS rf')
                            ->join(
                                'rutas_flujo_detalle AS rfd',
                                'rf.id', '=', 'rfd.ruta_flujo_id'
                            )
                            ->join(
                                'flujos AS f',
                                'f.id', '=', 'rf.flujo_id'
                            )
                            ->join(
                                'personas AS p',
                                'p.id', '=', 'rf.persona_id'
                            )
                            ->join(
                                'areas AS a',
                                'a.id', '=', 'rf.area_id'
                            )
                            ->join(
                                'areas AS a2',
                                'a2.id', '=', 'rfd.area_id'
                            )
                            ->join(
                                'tiempos as t',
                                't.id', '=', 'rfd.tiempo_id'
                            )
                            ->select(
                                'f.nombre AS flujo', 'rf.estado AS cestado',
                                'rf.id', 'a2.nombre as area2', 'rfd.dtiempo',
                                't.nombre as tiempo', 'rfd.norden',
                                DB::raw(
                                    'CONCAT(
                                            IFNULL(p.paterno,"")," ",
                                            IFNULL(p.materno,"")," ",
                                            IFNULL(p.nombre,"")
                                        ) AS persona'
                                ),
                                'a.nombre AS area',
                                'rf.n_flujo_ok AS ok',
                                'rf.n_flujo_error AS error',
                                DB::raw(
                                    'IFNULL(rf.ruta_id_dep,"") AS dep'
                                ),
                                DB::raw(
                                    'DATE(rf.created_at) AS fruta'
                                ),
                                DB::raw(
                                    'IF(rf.estado=1,"Produccion",
                                            IF(rf.estado=2,"Pendiente","Inactivo")
                                        ) AS estado'
                                )
                            )
                            ->whereBetween('rf.created_at', array($fechaIni, $fechaFin))
                            //->where('rf.estado', '=', '1') }
                            
                            //->orderBy('n_flujo_ok','DESC')
                            //->orderBy('n_flujo_error','ASC')
                            ->orderBy('rf.id', 'desc')
                            ->get();
        //return $rutaFlujo;
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rutaFlujo
            )
        );
    }
    /**
     * Cumplimiento de ruta por tramite
     * POST reporte/cumprutaxtramite
     *
     * @return Response
     */
    public function postCumprutaxtramite()
    {
        /*$flujoId = implode("','",Input::get('flujo_id'));
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);*/
        $rutaFlujoId=Input::get('id');
        /*
        $query = "SELECT tr.id_union, r.id, s.nombre as software,
                p.nombre as persona, a.nombre as area, r.fecha_inicio,
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND alerta=0) AS 'ok',
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND alerta=1) AS 'error',
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND alerta=2) AS 'corregido'
                FROM rutas r 
                JOIN tablas_relacion tr ON r.tabla_relacion_id=tr.id
                    JOIN softwares s ON tr.software_id=s.id
                JOIN personas p ON r.persona_id=p.id
                JOIN areas a ON r.area_id=a.id
                WHERE r.fecha_inicio BETWEEN '$fechaIni' AND 
                      DATE_ADD('$fechaFin',INTERVAL 1 DAY) AND r.flujo_id=?";
*/
        $query ="SELECT tr.id_union AS tramite, r.id, 
                IF(tipo_persona='1','Natural',
                  IF(tipo_persona='2','Juridica',
                    IF(tipo_persona='3','Interna','Organización') )
                  ) AS tipo_persona,
                IF(tipo_persona='1',
                   CONCAT(tr.paterno,' ',tr.materno,' ',tr.nombre),
                  razon_social) AS persona,
                  IFNULL(tr.sumilla,'') as sumilla,
                  IF(
                     (SELECT COUNT(rd.id)
                        FROM rutas_detalle rd
                        WHERE rd.ruta_id=r.id
                              AND rd.alerta=1
                            ),'Trunco',
                        IF(
                            (SELECT COUNT(norden)
                             FROM rutas_detalle rd 
                             WHERE rd.ruta_id=r.id
                             AND rd.fecha_inicio IS NOT NULL
                             AND rd.dtiempo_final IS NULL
                             AND rd.estado=1 
                            ),'Inconcluso','Concluido'
                        )
                    ) AS estado,
                    IFNULL((SELECT concat(  min(norden),' (',a.nombre,')'  )
                             FROM rutas_detalle rd 
                             JOIN areas a ON rd.area_id=a.id
                             WHERE rd.ruta_id=r.id
                             AND rd.dtiempo_final IS NULL
                             AND rd.estado=1 
                             ORDER BY norden LIMIT 1),'' 
                    ) AS ultimo_paso_area,
                    IFNULL((SELECT a.nombre
                             FROM rutas_detalle rd 
                             JOIN areas a ON rd.area_id=a.id
                             WHERE rd.ruta_id=r.id
                             AND rd.dtiempo_final IS NULL
                             AND rd.estado=1 
                             ORDER BY norden LIMIT 1),'' 
                    ) AS ultima_area,
                    (SELECT count(norden)
                       FROM rutas_detalle rd 
                       WHERE rd.ruta_id=r.id
                       AND rd.estado=1 
                       ) AS total_pasos,
                IFNULL(tr.fecha_tramite,'') AS fecha_tramite, '' AS fecha_fin,
                IFNULL(r.fecha_inicio,'') AS fecha_inicio,
                (SELECT COUNT(alerta) 
                  FROM rutas_detalle rd 
                  WHERE r.id=rd.ruta_id 
                  AND alerta=0) AS 'ok',
                (SELECT COUNT(alerta) 
                  FROM rutas_detalle rd 
                  WHERE r.id=rd.ruta_id 
                  AND alerta=1) AS 'errorr',
                (SELECT COUNT(alerta) 
                  FROM rutas_detalle rd 
                  WHERE r.id=rd.ruta_id 
                  AND alerta=2) AS 'corregido'
                FROM tablas_relacion tr 
                JOIN rutas r ON tr.id=r.tabla_relacion_id
                WHERE r.ruta_flujo_id='".$rutaFlujoId."'
                AND r.estado=1
                AND tr.estado=1";

        $table=DB::select($query);

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$table
            )
        );

    }
    /**
     * Detalle del cumplimiento de ruta por tramite
     * POST reporte/rutaxtramite
     *
     * @return Response
     */
    public function postCumprutaxtramitedetalle()
    {

        $rutaId=Input::get('ruta_id');
        $table = DB::table('rutas as r')
                    ->join('rutas_detalle as rd', 'r.id', '=', 'rd.ruta_id')
                    ->join('rutas_detalle_verbo as v', 'rd.id', '=', 'v.ruta_detalle_id')
                    ->join('areas as a', 'rd.area_id', '=', 'a.id')
                    ->join('tiempos as t', 'rd.tiempo_id', '=', 't.id')
                    ->where('ruta_id', array($rutaId))
                    ->select(
                        'rd.id',
                        'rd.ruta_id',
                        DB::RAW('ifnull(a.nombre,"") as area'),
                        DB::RAW('ifnull(t.nombre,"") as tiempo'),
                        DB::RAW('ifnull(dtiempo,"") as dtiempo'),
                        DB::RAW('ifnull(rd.fecha_inicio,"") as fecha_inicio'),
                        DB::RAW('ifnull(dtiempo_final,"") as dtiempo_final'),
                        'norden',
                        'alerta',
                        'alerta_tipo',
                        //'v.nombre as verbo',
                        //DB::RAW('ifnull(scaneo,"") as scaneo'),
                        //'finalizo',
                        DB::RAW(
                            "
                            GROUP_CONCAT( 
                                CONCAT(
                                    v.nombre,
                                    ' => ',
                                     IF(v.finalizo=0,'Pendiente','Finalizado')
                                ) SEPARATOR '<br>'
                            ) as verbo_finalizo
                        "
                        )
                    )
                    ->groupBy('rd.id')
                    ->get();

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$table
            )
        );

    }
    /**
     * detalle de cumplimiento por area
     * POST reporte/estadoofficetrack
     *
     * @return Response
     */
    public function postCumpareadetalle2()
    {
        $rutaId=Input::get('ruta_id');
        $set=DB::select('SET group_concat_max_len := @@max_allowed_packet');
        $query =  DB::table('rutas as r')
                    ->join('rutas_detalle as rd','r.id','=','rd.ruta_id')
                    ->join('areas as a','rd.area_id','=','a.id')
                    ->join('rutas_detalle_verbo as v','rd.id','=','v.ruta_detalle_id')
                        ->leftjoin('roles as ro','v.rol_id','=','ro.id')
                        ->leftjoin('verbos as vs','v.verbo_id','=','vs.id')
                        ->leftjoin('documentos as d','v.documento_id','=','d.id')
                        ->leftjoin('personas as p','v.usuario_updated_at','=','p.id')
                    ->join('tiempos as t','rd.tiempo_id','=','t.id')
                    ->join('tablas_relacion as tr','r.tabla_relacion_id','=','tr.id')
                    ->where('r.id',array($rutaId))
                    //->where('rd.condicion',0)
                    ->where('r.estado',1)
                    ->where('rd.estado',1)
                    ->where('v.estado',1)
                    ->select(
                        'a.nombre as area',
                        'tr.id_union',
                        'rd.id',
                        DB::RAW('ifnull(rd.norden,"") as norden'),
                        DB::RAW('ifnull(rd.fecha_inicio,"") as fecha_inicio'),
                        DB::RAW('ifnull(t.nombre,"") as tiempo'),
                        DB::RAW('ifnull(rd.dtiempo,"") as dtiempo'),
                        DB::RAW('ifnull(rd.dtiempo_final,"") as dtiempo_final'),
                        'norden',
                        'alerta_tipo',
                        'rd.alerta',
                        DB::RAW("
                            GROUP_CONCAT(
                                    IFNULL(v.nombre,'') SEPARATOR ', '
                            ) AS descripcion_v
                        "),
                        DB::RAW("
                            GROUP_CONCAT(
                                    IFNULL(v.observacion,'') SEPARATOR ', '
                            ) AS observacion
                        "),
                        //'v.nombre AS descripcion_v',
                        //DB::RAW('ifnull(scaneo,"") as scaneo'),
                        //'finalizo',
                        DB::RAW("
                            GROUP_CONCAT( 
                                IF(v.finalizo=0,'Pendiente','Finalizado')
                                     SEPARATOR ', '
                            ) AS estado_accion
                        "),
                        DB::RAW("
                            GROUP_CONCAT( 
                                    CONCAT(
                                            v.nombre,
                                            ' => ',
                                             IF(v.finalizo=0,'Pendiente','Finalizado')
                                    ) SEPARATOR '<br>'
                            ) AS verbo_finalizo
                        "),
                        DB::RAW("
                            GROUP_CONCAT( 
                                IFNULL(ro.nombre,'') SEPARATOR ', '
                            ) AS rol
                        "),
                        DB::RAW("
                            GROUP_CONCAT( 
                                IFNULL(d.nombre,'') SEPARATOR ', '
                            ) AS documento
                        "),
                        DB::RAW("
                            GROUP_CONCAT( 
                                IFNULL(vs.nombre,'') SEPARATOR ', '
                            ) AS verbo
                        "),
                        DB::RAW("
                          IFNULL(GROUP_CONCAT(
                              CONCAT(
                                  '<b>',
                                  IFNULL(v.orden,' '),
                                  '</b>',
                                   '.- ',
                                  ro.nombre,
                                   ' tiene que ',
                                  vs.nombre,
                                   ' ',
                                  IFNULL(d.nombre,''),
                                   ' (',
                                  v.nombre,
                                   ' )'
                              )
                          ORDER BY v.orden ASC
                          SEPARATOR '|'),'') AS verbo2
                        "),
                        DB::RAW("
                          IFNULL(GROUP_CONCAT(
                              CONCAT(
                                  '<b>',
                                  IFNULL(v.orden,' '),
                                  '</b>',
                                   '.- ',
                                  IF(v.finalizo=0,'<font color=#EC2121>Pendiente</font>',CONCAT('<font color=#22D72F>Finalizó</font>(',p.paterno,' ',p.materno,', ',p.nombre,' ',IFNULL(v.documento,''),'//',IFNULL(v.observacion,''),')' ) )
                              )
                          ORDER BY v.orden ASC
                          SEPARATOR '|'),'') AS ordenv
                        ")/*,
                        DB::RAW("
                            CASE rd.alerta
                                WHEN '0' THEN 'Sin Alerta'
                                WHEN '1' THEN 'Alerta'
                                WHEN '2' THEN 'Alerta Validada'
                                ELSE '' 
                            END  AS alerta
                        ")*/
                    )
                    ->groupBy('rd.id')
                    ->orderBy('rd.norden')
                    ->get();
        return Response::json(
             array(
                 'rst'=>1,
                'datos'=>$query
             )
        );
    }
    /**
     * detalle de cumplimiento por area
     * POST reporte/estadoofficetrack
     *
     * @return Response
     */
    public function postCumpareadetalle()
    {
        
        $rutaFlujoId=Input::get('ruta_flujo_id');
        //recibir los parametros y enviarlos al modelo, ahi ejecutar el query
        $query ="SELECT tr.id_union AS tramite, r.id, 
                IF(tipo_persona='1','natural',
                  IF(tipo_persona='2','juridica','interna')
                  ) AS tipo_persona,
                IF(tipo_persona='1',
                   CONCAT(
                    IFNULL(tr.paterno,''),' ',
                    IFNULL(tr.materno,''),' ',
                    IFNULL(tr.nombre,'')),
                  razon_social) AS persona,
                  IFNULL(tr.sumilla,'') as sumilla,
                  IF(
                     (SELECT COUNT(rd.id)
                        FROM rutas_detalle rd
                        WHERE rd.ruta_id=r.id
                              AND rd.alerta=1
                              AND rd.estado=1
                            ),'Trunco',
                        IF(
                            (SELECT COUNT(norden)
                             FROM rutas_detalle rd 
                             WHERE rd.ruta_id=r.id
                             AND rd.fecha_inicio IS NOT NULL
                             AND rd.dtiempo_final IS NULL
                             AND rd.estado=1 
                            ),'Inconcluso','Concluido'
                        )
                    ) AS estado,
                    IFNULL((SELECT norden
                             FROM rutas_detalle rd 
                             WHERE rd.ruta_id=r.id
                             AND rd.fecha_inicio IS NOT NULL
                             AND rd.dtiempo_final IS NULL
                             AND rd.estado=1 
                             ORDER BY norden LIMIT 1),'' 
                        ) AS ultimo_paso,
                        IFNULL((SELECT a.nombre
                                 FROM rutas_detalle rd 
                                 JOIN areas a ON rd.area_id=a.id
                                 WHERE rd.ruta_id=r.id
                                 AND rd.fecha_inicio IS NOT NULL
                                 AND rd.dtiempo_final IS NULL
                                 AND rd.estado=1 
                                 ORDER BY norden LIMIT 1),'' 
                            ) AS ultima_area,
                IFNULL(tr.fecha_tramite,'') AS fecha_tramite, '' AS fecha_fin,
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND estado=1 AND alerta=0) AS 'ok',
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND estado=1 AND alerta=1) AS 'errorr',
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND estado=1 AND alerta=2) AS 'corregido'
                FROM tablas_relacion tr 
                JOIN rutas r ON tr.id=r.tabla_relacion_id
                WHERE r.ruta_flujo_id=? AND tr.estado=1
                AND r.estado=1 ";
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>DB::Select($query, array($rutaFlujoId))
            )
        );
        //return Response::make($output, 200, $headers);
    }
    /**
     * Cumplimiento de are
     * POST reporte/tecnicoofficetrack
     *
     * @return Response
     */
    public function postCumparea()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $areaId=implode("','",Input::get('area_id'));
        $estadoF=implode(",",Input::get('estado_id'));

        $query="SELECT rf.flujo_id,f.nombre AS proceso, rf.id AS ruta_flujo_id, 
                CONCAT(p.paterno,' ',p.materno,' ',p.nombre) AS duenio,
                a.nombre  AS area_duenio,
                (SELECT COUNT(DISTINCT a.id) 
                FROM areas a JOIN rutas_flujo_detalle rfd ON a.id=rfd.area_id
                WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1) AS n_areas,
                (SELECT COUNT(DISTINCT rfd.id) 
                FROM rutas_flujo_detalle rfd 
                WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1) AS n_pasos,
                CONCAT(
                    IFNULL(
                        (SELECT CONCAT(t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='1'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') ,
                    IFNULL(
                        (SELECT CONCAT(' ', t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='2'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') ,
                    IFNULL(
                        (SELECT CONCAT(' ', t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='3'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') ,
                    IFNULL(
                        (SELECT CONCAT(' ', t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='4'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') 
                ) AS tiempo,
                IFNULL(max(r.fecha_inicio),'')  AS fecha_inicio,
                rf.created_at AS fecha_creacion,
                rf.updated_at AS fecha_produccion,
                count(distinct(rf.id)) AS ntramites,
                rf.estado AS estado_final
                FROM flujos f 
                JOIN rutas_flujo rf ON rf.flujo_id=f.id
                JOIN personas p ON rf.persona_id=p.id
                JOIN rutas_flujo_detalle rfd ON rfd.ruta_flujo_id=rf.id AND rfd.estado=1
                JOIN areas a ON rf.area_id=a.id
                LEFT JOIN rutas r ON r.ruta_flujo_id=rf.id
                WHERE f.area_id IN ('".$areaId."') 
                AND rfd.area_id IN (
                                    SELECT a.id
                                    FROM area_cargo_persona acp
                                    INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                    WHERE acp.estado=1
                                    AND cp.persona_id=".Auth::user()->id."
                                  )
                AND f.estado=1 
                AND a.estado=1
                AND DATE(rf.updated_at) BETWEEN '".$fechaIni."' AND '".$fechaFin."'
                AND rf.estado IN (".$estadoF.")
                GROUP BY rf.id
                ORDER BY rf.estado,a.nombre";
                
        $result= DB::Select($query);
        //echo $query;
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }
        /**
     * Cumplimiento de are
     * POST reporte/tecnicoofficetrack
     *
     * @return Response
     */
    public function postCumparea2()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $areaId=implode("','",Input::get('flujo_id'));
        $estadoF=implode(",",Input::get('estado_id'));
        $tipofecha=Input::get('tipofecha');
        $tf="rf.updated_at";
        if($tipofecha==2){
          $tf="r.fecha_inicio";
        }

        $query="SELECT rf.flujo_id,f.nombre AS proceso, rf.id AS ruta_flujo_id, 
                CONCAT(p.paterno,' ',p.materno,' ',p.nombre) AS duenio,
                a.nombre  AS area_duenio,
                (SELECT COUNT(DISTINCT a.id) 
                FROM areas a JOIN rutas_flujo_detalle rfd ON a.id=rfd.area_id
                WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1) AS n_areas,
                (SELECT COUNT(DISTINCT rfd.id) 
                FROM rutas_flujo_detalle rfd 
                WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1) AS n_pasos,
                CONCAT(
                    IFNULL(
                        (SELECT CONCAT(t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='1'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') ,
                    IFNULL(
                        (SELECT CONCAT(' ', t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='2'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') ,
                    IFNULL(
                        (SELECT CONCAT(' ', t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='3'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') ,
                    IFNULL(
                        (SELECT CONCAT(' ', t.nombre , ': ',SUM(dtiempo))
                        FROM rutas_flujo_detalle AS rfd 
                        JOIN tiempos t ON rfd.tiempo_id=t.id AND t.id='4'
                        WHERE rfd.ruta_flujo_id=rf.id AND rfd.estado=1)  ,'') 
                ) AS tiempo,
                IFNULL(max(r.fecha_inicio),'')  AS fecha_inicio,
                rf.created_at AS fecha_creacion,
                rf.updated_at AS fecha_produccion,
                (SELECT CONCAT(count(distinct(r.id)),'/',count(r2.id)) FROM rutas r2 WHERE r2.estado=1 and r2.ruta_flujo_id=rf.id) AS ntramites,
                rf.estado AS estado_final
                FROM flujos f 
                JOIN rutas_flujo rf ON rf.flujo_id=f.id
                JOIN personas p ON rf.persona_id=p.id
                JOIN rutas_flujo_detalle rfd ON rfd.ruta_flujo_id=rf.id AND rfd.estado=1
                JOIN areas a ON rf.area_id=a.id
                LEFT JOIN rutas r ON r.ruta_flujo_id=rf.id
                WHERE f.id IN ('".$areaId."') 
                AND rfd.area_id IN (
                                    SELECT a.id
                                    FROM area_cargo_persona acp
                                    INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                    WHERE acp.estado=1
                                    AND cp.persona_id=".Auth::user()->id."
                                  )
                AND f.estado=1
                AND a.estado=1
                AND DATE(".$tf.") BETWEEN '".$fechaIni."' AND '".$fechaFin."'
                AND rf.estado IN (".$estadoF.")
                GROUP BY rf.id
                ORDER BY rf.estado,a.nombre";
//echo $query;
        $result =DB::Select($query);
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }
}
