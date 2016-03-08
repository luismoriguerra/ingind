<?php

class ReporteController extends BaseController
{

    public function postSipoc()
    {
      //$html=View::make("admin.reporte.sipoc");
      $html='Hola';
      //return PDF::load($html, 'A4', 'landscape')->download('prueba');
      echo $html;
    }
  /**
   * bandeja de tramite, devuelve la consulta de tramites que se asignan 
   * a una determinada area que pertenece el usuario
   */

    public function postTrabajoasignado()
    {
        $wfecha="";
        if(Input::has('fecha')){
          $fecha = Input::get('fecha');
          list($fechaIni,$fechaFin) = explode(" - ", $fecha);
          $wfecha= " AND DATE(r.fecha_inicio) BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
        }

        $autoriza="";
        if(Input::has('autoriza')){
        $autoriza=" AND tr.persona_autoriza_id IN ('".implode("','",Input::get('autoriza'))."') ";
        }

        $responsable="";
        if(Input::has('responsable')){
        $responsable=" AND tr.persona_responsable_id IN ('".implode("','",Input::get('responsable'))."') ";
        }

        $miembros="";$miembrosF="";
        if(Input::has('miembros')){
        $miembros=" AND cd2.persona_id IN ('".implode("','",Input::get('miembros'))."') ";
        $miembrosF=" AND t.miembrosvalida=1 ";
        }

        $estadoF="";
        if(Input::has('estado_id')){
        $estadoF=" AND t.estado IN ('".implode("','",Input::get('estado_id'))."') ";
        }

        $flujo_id="";
        if(Input::has('flujo_id')){
        $flujo_id=" AND f.id IN ('".implode("','",Input::get('flujo_id'))."') ";
        }
        
        $carta="";
        if(Input::has('carta_inicio')){
        $carta=" AND c.nro_carta LIKE '".Input::get('carta_inicio')."%' ";
        }

        $objetivo="";
        if(Input::has('objetivo')){
        $objetivo=" AND c.objetivo LIKE '".Input::get('objetivo')."%' ";
        }

        $sql="SELECT *
              FROM (
              SELECT f.nombre proceso,
              ( SELECT CONCAT(p.paterno,' ',p.materno,', ',p.nombre,'|',a.nombre) 
                FROM personas p
                INNER JOIN areas a ON a.id=p.area_id
                WHERE p.id=tr.persona_autoriza_id
              ) autoriza,
              ( SELECT CONCAT(p.paterno,' ',p.materno,', ',p.nombre,'|',r.nombre) 
                FROM personas p
                INNER JOIN roles r ON r.id=p.rol_id
                WHERE p.id=tr.persona_responsable_id
              ) responsable,
              c.nro_carta,c.objetivo,
              GROUP_CONCAT( CONCAT(p2.paterno,' ',p2.materno,', ',p2.nombre) SEPARATOR ' | ' ) miembros,
              IF(
                ( SELECT count(cd2.id)
                  FROM carta_desglose cd2
                  WHERE cd2.carta_id=c.id
                   ".$miembros." 
                ) > 0, 1,0
              ) miembrosvalida,
              DATE(r.fecha_inicio) fecha_inicio,MAX(cd.fecha_fin) fecha_fin,
              IF(
                ( SELECT count(rd.id)
                  FROM rutas_detalle rd
                  WHERE rd.ruta_id=r.id
                  AND rd.estado=1
                  AND rd.condicion=0
                  AND dtiempo_final IS NULL
                ) > 0, 'Inconcluso' ,'Concluido'
              ) estado 
              FROM cartas c
              INNER JOIN carta_desglose cd ON cd.carta_id=c.id
              INNER JOIN personas p2 ON p2.id=cd.persona_id
              INNER JOIN tablas_relacion tr ON c.nro_carta=tr.id_union AND tr.estado=1
              INNER JOIN rutas r ON r.tabla_relacion_id=tr.id 
              INNER JOIN flujos f ON f.id=r.flujo_id 
              WHERE r.estado=1
               ".$wfecha.$autoriza.$responsable.$flujo_id.$carta.$objetivo." 
              GROUP BY r.id 
              ) t WHERE 1=1 ".$estadoF.$miembrosF;

        $table=DB::select($sql);

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$table
            )
        );
    }

   public function postBandejatramite()
   {
        $input=Input::all();
        if (is_array($input)) {
            $input=implode("','", $input);
        }
        $rst=VisualizacionTramite::BandejaTramites($input);
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst, 'input'=>$input
            )
        );
   }

   public function postBandejatramiteot()
   {
        $rst=VisualizacionTramite::BandejaTramitesot();
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst
            )
        );
   }
   /**
   * bandeja de tramite, devuelve la consulta de tramites que se asignan 
   * a una determinada area que pertenece el usuario
   */
   public function postBandejatramitef()
   {
        $input=Input::all();
        if (is_array($input)) {
            $input=implode("','", $input);
        }
        $rst=VisualizacionTramite::BandejaTramitesf($input);
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst, 'input'=>$input
            )
        );
   }
   /**
   * bandeja de tramite, devuelve la consulta de tramites que se asignan 
   * a una determinada area que pertenece el usuario
   */
   public function postBandejatramitedetalle()
   {
        $input=Input::all();
        if (is_array($input)) {
            $input=implode("','", $input);
        }
        $rst=VisualizacionTramite::BandejaTramites($input);
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$rst, 'input'=>$input
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

        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $tipofecha=Input::get('tipofecha');
        $tf='';
        if($tipofecha==2){
          $tf=" AND r.fecha_inicio BETWEEN '".$fechaIni."' AND '".$fechaFin."' ";
        }
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
                ts.nombre AS tipo_persona,
                IF(tr.tipo_persona=1 or tr.tipo_persona=6,
                    CONCAT(tr.paterno,' ',tr.materno,', ',tr.nombre),
                    IF(tr.tipo_persona=2,
                        CONCAT(tr.razon_social,' | RUC:',tr.ruc),
                        IF(tr.tipo_persona=3,
                            a.nombre,
                            IF(tr.tipo_persona=4 or tr.tipo_persona=5,
                                tr.razon_social,''
                            )
                        )
                    )
                ) AS persona,
                  IFNULL(tr.sumilla,'') as sumilla,
                  IF(
                     (SELECT COUNT(rd.id)
                        FROM rutas_detalle rd
                        WHERE rd.ruta_id=r.id
                              AND rd.alerta=1
                              AND rd.alerta_tipo>1
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
                IF( IFNULL(tr.persona_autoriza_id,'')!='',(SELECT CONCAT(paterno,' ',materno,', ',nombre) FROM personas where id=tr.persona_autoriza_id),'' ) autoriza,
                IF( IFNULL(tr.persona_responsable_id,'')!='',(SELECT CONCAT(paterno,' ',materno,', ',nombre) FROM personas where id=tr.persona_responsable_id),'' ) responsable,
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
                inner JOIN rutas r ON tr.id=r.tabla_relacion_id and r.estado=1
                inner join tipo_solicitante ts ON ts.id=tr.tipo_persona and ts.estado=1
                LEFT JOIN areas a ON a.id=tr.area_id
                WHERE r.ruta_flujo_id='".$rutaFlujoId."'
                $tf
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
                    ->where('r.estado',1)
                    ->where('rd.estado',1)
                    ->where('v.estado',1)
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
                ts.nombre AS tipo_persona,
                IF(tr.tipo_persona=1 or tr.tipo_persona=6,
                    CONCAT(tr.paterno,' ',tr.materno,', ',tr.nombre),
                    IF(tr.tipo_persona=2,
                        CONCAT(tr.razon_social,' | RUC:',tr.ruc),
                        IF(tr.tipo_persona=3,
                            a.nombre,
                            IF(tr.tipo_persona=4 or tr.tipo_persona=5,
                                tr.razon_social,''
                            )
                        )
                    )
                ) AS persona,
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
                IF( IFNULL(tr.persona_autoriza_id,'')!='',(SELECT CONCAT(paterno,' ',materno,', ',nombre) FROM personas where id=tr.persona_autoriza_id),'' ) autoriza,
                IF( IFNULL(tr.persona_responsable_id,'')!='',(SELECT CONCAT(paterno,' ',materno,', ',nombre) FROM personas where id=tr.persona_responsable_id),'' ) responsable,
                IFNULL(tr.fecha_tramite,'') AS fecha_tramite, '' AS fecha_fin,
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND estado=1 AND alerta=0) AS 'ok',
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND estado=1 AND alerta=1) AS 'errorr',
                (SELECT COUNT(alerta) FROM rutas_detalle rd WHERE r.id=rd.ruta_id AND estado=1 AND alerta=2) AS 'corregido'
                FROM tablas_relacion tr 
                JOIN rutas r ON tr.id=r.tabla_relacion_id
                inner join tipo_solicitante ts ON ts.id=tr.tipo_persona and ts.estado=1
                LEFT JOIN areas a ON a.id=tr.area_id
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
        $tipoFlujo='';
        if( Input::has('tipo_flujo') AND Input::get('tipo_flujo')!='' ){
          $tipoFlujo=" AND f.tipo_flujo=2 ";
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
                count(distinct(r.id)) AS ntramites,
                rf.estado AS estado_final
                FROM flujos f 
                JOIN rutas_flujo rf ON rf.flujo_id=f.id
                JOIN personas p ON rf.persona_id=p.id
                JOIN rutas_flujo_detalle rfd ON rfd.ruta_flujo_id=rf.id AND rfd.estado=1
                JOIN areas a ON rf.area_id=a.id
                LEFT JOIN rutas r ON r.ruta_flujo_id=rf.id
                WHERE rf.area_id IN ('".$areaId."') 
                 ".$tipoFlujo." 
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

        $tipoFlujo='';
        if( Input::has('tipo_flujo') AND Input::get('tipo_flujo')!='' ){
          $tipoFlujo=" AND f.tipo_flujo=2 ";
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
                CONCAT(count(distinct(r.id)),'/',count(DISTINCT(ruf.id))) ntramites,
                count(DISTINCT(IF(ruf.dtiempo_final is null,null,ruf.id))) concluidos,
                count(DISTINCT(IF(ruf.dtiempo_final is null,ruf.id,null))) inconclusos,
                rf.estado AS estado_final
                FROM flujos f 
                JOIN rutas_flujo rf ON rf.flujo_id=f.id
                JOIN personas p ON rf.persona_id=p.id
                JOIN rutas_flujo_detalle rfd ON rfd.ruta_flujo_id=rf.id AND rfd.estado=1
                JOIN areas a ON rf.area_id=a.id
                LEFT JOIN rutas r ON r.ruta_flujo_id=rf.id
                LEFT JOIN (
                      SELECT ru.id,rd.fecha_inicio,rd.id rdid,rd.alerta,rd.alerta_tipo,rd.dtiempo_final
                      FROM rutas ru 
                      INNER JOIN rutas_detalle rd ON rd.ruta_id=ru.id AND rd.estado=1
                      WHERE ru.estado=1
                      AND CONCAT(rd.fecha_inicio,'_',rd.id) IN (
                        SELECT MAX(CONCAT(rdf.fecha_inicio,'_',rdf.id))
                        FROM rutas_detalle rdf
                        WHERE rdf.ruta_id=ru.id
                      )
                      GROUP BY ru.id
                ) ruf ON ruf.id=r.id
                WHERE f.id IN ('".$areaId."') 
                AND f.estado=1
                AND a.estado=1
                AND DATE(".$tf.") BETWEEN '".$fechaIni."' AND '".$fechaFin."'
                AND rf.estado IN (".$estadoF.")
                 ".$tipoFlujo." 
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

    public function postAcciones()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $areaId=implode('","',Input::get('area_id'));
        $estadoF=implode(",",Input::get('estado_id'));

        $query='SELECT rd.id,a.nombre area,a2.nombre areapaso,CONCAT_WS(" ",p.paterno,p.materno,p.nombre) persona,f.nombre proceso,
                IF(r.estado=1,"Producción",
                  "Pendiente" 
                ) estado,rd.norden,
                CONCAT(count(rd.id),"/",
                  IFNULL(
                    (
                    SELECT count(rdv2.id)
                    FROM rutas_flujo_detalle_verbo rdv2
                    WHERE rdv2.estado=1
                    AND rdv2.ruta_flujo_detalle_id=rd.id
                    GROUP BY rdv2.created_at
                    ORDER BY rdv2.created_at DESC
                    LIMIT 1,1
                    ),"0"
                  )
                ) nverbos,max(rdv.created_at) fecha

                FROM rutas_flujo r
                INNER JOIN rutas_flujo_detalle rd ON r.id=rd.ruta_flujo_id AND rd.estado=1
                INNER JOIN rutas_flujo_detalle_verbo rdv ON rd.id=rdv.ruta_flujo_detalle_id AND rdv.estado=1
                INNER JOIN personas p ON p.id=r.persona_id
                INNER JOIN flujos f ON f.id=r.flujo_id
                INNER JOIN areas a ON a.id=r.area_id
                INNER JOIN areas a2 ON a2.id=rd.area_id
                WHERE rd.area_id IN ("'.$areaId.'") 
                AND r.estado IN ('.$estadoF.')
                AND date(rdv.created_at) BETWEEN "'.$fechaIni.'" AND "'.$fechaFin.'"
                GROUP BY rd.id
                ORDER BY r.id,rd.norden';
                
        $result= DB::Select($query);
        //echo $query;
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }

    public function postDocumentos()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $areaId=implode('","',Input::get('area_id'));

        $query='SELECT rdv.id,a.nombre area, f.nombre proceso, ts.nombre tipo_solicitante,
                t.id_union tramite, d.nombre tipo_documento, rdv.documento
                FROM rutas r
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1
                INNER JOIN rutas_detalle_verbo rdv ON rdv.ruta_detalle_id=rd.id AND rdv.estado=1
                INNER JOIN documentos d ON rdv.documento_id=d.id 
                INNER JOIN areas a ON rd.area_id=a.id
                INNER JOIN flujos f ON r.flujo_id=f.id
                INNER JOIN tablas_relacion t ON r.tabla_relacion_id=t.id
                INNER JOIN tipo_solicitante ts ON t.tipo_persona=ts.id
                LEFT JOIN areas a2 ON t.area_id=a2.id
                WHERE rdv.documento IS NOT NULL
                AND rdv.verbo_id=1
                AND rdv.finalizo=1
                AND r.estado=1
                AND rd.area_id IN ("'.$areaId.'") 
                AND date(rdv.updated_at) BETWEEN "'.$fechaIni.'" AND "'.$fechaFin.'" ';
                
        $result= DB::Select($query);
        //echo $query;
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }

    public function postExpediente()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $filtrofecha=" AND DATE(r.fecha_inicio) BETWEEN '".$fechaIni."' and '".$fechaFin."'";
        $flujo="";$filtroflujo="";
        if( Input::has('flujo') ){
          $flujo=implode("','",Input::get('flujo'));
          $filtrofecha=" AND DATE(tr.fecha_tramite) BETWEEN '".$fechaIni."' and '".$fechaFin."'";
          $filtroflujo=" AND r.flujo_id IN ('".$flujo."')";
        }
        $query ="SELECT tr.id_union AS tramite, r.id, f.nombre flujo,
                ts.nombre AS tipo_persona,
                IF(tr.tipo_persona=1 or tr.tipo_persona=6,
                    CONCAT(tr.paterno,' ',tr.materno,', ',tr.nombre),
                    IF(tr.tipo_persona=2,
                        CONCAT(tr.razon_social,' | RUC:',tr.ruc),
                        IF(tr.tipo_persona=3,
                            a.nombre,
                            IF(tr.tipo_persona=4 or tr.tipo_persona=5,
                                tr.razon_social,''
                            )
                        )
                    )
                ) AS persona,
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
                JOIN rutas r ON tr.id=r.tabla_relacion_id and r.estado=1
                INNER JOIN flujos f ON f.id=r.flujo_id and f.estado=1
                INNER JOIN tipo_solicitante ts ON ts.id=tr.tipo_persona and ts.estado=1
                LEFT JOIN areas a ON a.id=tr.area_id
                WHERE tr.estado=1
                ".$filtrofecha.$filtroflujo;

        $table=DB::select($query);

        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$table
            )
        );

    }

    public function postExpedientedetalle()
    {
      $id=Input::get('id');

      $query="SELECT rdv.id,tr.id_union,ts.nombre tipo_solicitante,
              a2.nombre area_proceso,f.nombre proceso,
              (SELECT CONCAT(count(DISTINCT(rd2.area_id)),' / ',count(rd2.id)) FROM rutas_detalle rd2 WHERE rd2.ruta_id=r.id GROUP BY rd2.ruta_id)
             nanp,
            a2.nombre area_generada,d.nombre tipo_documento,rdv.documento   
            FROM rutas r
            inner join rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1
            inner join rutas_detalle_verbo rdv ON rdv.ruta_detalle_id=rd.id AND rdv.estado=1
            inner join documentos d ON d.id=rdv.documento_id
            inner join areas a2 ON a2.id=r.area_id
            inner join flujos f ON f.id=r.flujo_id AND f.estado=1
            inner join tablas_relacion tr ON tr.id=r.tabla_relacion_id
            inner join tipo_solicitante ts ON ts.id=tr.tipo_persona
            LEFT JOIN areas a ON a.id=tr.area_id
            WHERE r.estado=1
            AND rdv.finalizo=1
            AND rdv.verbo_id=1
            AND r.id='".$id."' ";

      $table=DB::select($query);

      return Response::json(
          array(
              'rst'=>1,
              'datos'=>$table
          )
      );

    }

    public function postDocumentoxproceso()
    {
        $fecha = Input::get('fecha');
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $areaId=implode('","',Input::get('area_id'));

        $query='SELECT a.nombre area, f.nombre proceso, d.nombre tipo_documento, count(DISTINCT(r.id)) ntramites, count(r.id) ndocumentos
                FROM rutas r
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1
                INNER JOIN rutas_detalle_verbo rdv ON rdv.ruta_detalle_id=rd.id AND rdv.estado=1
                INNER JOIN documentos d ON rdv.documento_id=d.id 
                INNER JOIN areas a ON rd.area_id=a.id
                INNER JOIN flujos f ON r.flujo_id=f.id
                INNER JOIN tablas_relacion t ON r.tabla_relacion_id=t.id
                INNER JOIN tipo_solicitante ts ON t.tipo_persona=ts.id
                LEFT JOIN areas a2 ON t.area_id=a2.id
                WHERE rdv.documento IS NOT NULL
                AND rdv.verbo_id=1
                AND rdv.finalizo=1
                AND r.estado=1
                AND rd.area_id IN ("'.$areaId.'") 
                AND date(rdv.updated_at) BETWEEN "'.$fechaIni.'" AND "'.$fechaFin.'" 
                GROUP BY a.nombre,f.nombre,d.nombre
                ORDER BY a.nombre,f.nombre,d.nombre';
                
        $result= DB::Select($query);
        //echo $query;
        return Response::json(
            array(
                'rst'=>1,
                'datos'=>$result
            )
        );
    }

    public function postUsuarios(){
      $r=Usuario::ListarUsuarios();

      return Response::json(
            array(
                'rst'=>1,
                'datos'=>$r
            )
        );
    }

    public function postDocplataforma(){
      $fecha = Input::get('fecha');
      list($fechaIni,$fechaFin) = explode(" - ", $fecha);
      $sql="SELECT f.nombre proceso_pla,tr.id_union plataforma,r.fecha_inicio,rd.dtiempo_final
            ,f2.nombre proceso,tr2.id_union gestion,r2.fecha_inicio fecha_inicio_gestion, rd2f.norden ult_paso
            ,IFNULL(rd3f.norden,rd2f.norden) act_paso, 
            IFNULL(DATE_ADD(r2.fecha_inicio, INTERVAL t.totalminutos MINUTE),DATE_ADD(r2.fecha_inicio, INTERVAL t2.totalminutos MINUTE)) fecha_fin
            , IFNULL(rd3f.dtiempo_final,rd2f.dtiempo_final) tiempo_realizado
            FROM rutas r
            INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1
            INNER JOIN 
            ( SELECT MAX(id) id,ruta_id
              FROM rutas_detalle
              WHERE estado=1
              GROUP BY ruta_id
            ) rdm ON rdm.id=rd.id 
            INNER JOIN tablas_relacion tr ON tr.id=r.tabla_relacion_id AND tr.estado=1 
                      AND tr.fecha_tramite BETWEEN '$fechaIni' AND '$fechaFin'
            INNER JOIN flujos f ON f.id=r.flujo_id
            INNER JOIN areas_internas ai ON ai.flujo_id=f.id
            LEFT JOIN tablas_relacion tr2 ON tr2.id_union=tr.id_union AND tr2.id!=tr.id AND tr2.estado=1
            LEFT JOIN rutas r2 ON r2.tabla_relacion_id=tr2.id AND r2.estado=1
            LEFT JOIN flujos f2 ON f2.id=r2.flujo_id
            LEFT JOIN 
            ( SELECT rd2.*
              FROM rutas_detalle rd2 
              INNER JOIN 
              ( SELECT MAX(id) id,ruta_id
                FROM rutas_detalle
                WHERE estado=1
                GROUP BY ruta_id
              ) rdm2 ON rdm2.id=rd2.id 
            ) rd2f ON rd2f.ruta_id=r2.id AND rd2f.estado=1
            LEFT JOIN 
            ( SELECT rd2.*
              FROM rutas_detalle rd2 
              INNER JOIN 
              ( SELECT MIN(id) id,ruta_id
                FROM rutas_detalle
                WHERE estado=1
                AND dtiempo_final IS NULL
                GROUP BY ruta_id
              ) rdm2 ON rdm2.id=rd2.id 
            ) rd3f ON rd3f.ruta_id=r2.id AND rd3f.estado=1
            LEFT JOIN tiempos t ON t.id=rd3f.tiempo_id
            LEFT JOIN tiempos t2 ON t2.id=rd2f.tiempo_id
            WHERE r.estado=1
            order by proceso DESC,rd.dtiempo_final";

      $r=DB::select($sql);

      return Response::json(
            array(
                'rst'=>1,
                'datos'=>$r
            )
        );
    }
}
