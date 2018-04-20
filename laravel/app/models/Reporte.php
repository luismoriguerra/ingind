<?php
class Reporte extends Eloquent
{
    public static function TramiteProceso( $array ){

        $sql=   "SELECT rf.flujo_id,f.nombre AS proceso, rf.id AS ruta_flujo_id, 
                CONCAT(p.paterno,' ',p.materno,' ',p.nombre) AS duenio,
                a.nombre  AS area_duenio,
                COUNT( DISTINCT(a2.id) ) AS n_areas,
                COUNT(rfd.id) AS n_pasos,
                CONCAT( 
                    'Día: ',
                    SUM( IF( t.id=2,rfd.dtiempo,0 ) ),
                    ' Hora: ',
                    SUM( IF( t.id=1,rfd.dtiempo,0 ) ) 
                ) tiempo,
                rf.created_at AS fecha_creacion,
                rf.updated_at AS fecha_produccion,
                detruta.ntramites,
                detruta.concluidos,
                detruta.inconclusos,
                rf.estado_final
                FROM flujos f 
                INNER JOIN rutas_flujo rf ON rf.flujo_id=f.id
                INNER JOIN personas p ON rf.persona_id=p.id 
                INNER JOIN areas a ON rf.area_id=a.id AND a.estado=1
                INNER JOIN rutas_flujo_detalle rfd ON rfd.ruta_flujo_id=rf.id AND rfd.estado=1
                INNER JOIN areas a2 ON rfd.area_id=a2.id AND a2.estado=1
                INNER JOIN tiempos t ON rfd.tiempo_id=t.id AND t.estado=1
                INNER JOIN 
                ( 
                    SELECT deru.ruta_flujo_id,
                    COUNT( deru.id ) ntramites,
                    COUNT( IF( deru.rutaestado=1,deru.id,NULL ) ) concluidos, 
                    COUNT( IF( deru.rutaestado=0,deru.id,NULL ) ) inconclusos
                    FROM (
                        SELECT r.id,r.ruta_flujo_id, IF( COUNT(rd.id)=COUNT(rd.dtiempo_final),1,0 ) rutaestado
                        FROM rutas r 
                        INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1
                        WHERE rd.ruta_id
                        AND r.estado=1
                        AND DATE(r.fecha_inicio) BETWEEN '".$array['fechaini']."' AND '".$array['fechafin']."'
                        GROUP BY r.id
                    ) deru
                    GROUP BY deru.ruta_flujo_id
                ) detruta ON detruta.ruta_flujo_id=rf.id
                WHERE f.estado=1".
                $array['where']."
                GROUP BY rf.id
                ORDER BY a.nombre";

        $r= DB::select($sql);
        return $r;
    }

    public static function Tramite( $array ){

        $sql =" SELECT tr.id_union AS tramite, r.id, r.ruta_flujo_id, 
                ts.nombre AS tipo_persona,
                IF(tr.tipo_persona=1 or tr.tipo_persona=6,
                    CONCAT(IFNULL(tr.paterno,''),' ',IFNULL(tr.materno,''),', ',IFNULL(tr.nombre,'')),
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
                IF( MIN( IF( rd.dtiempo_final IS NULL AND rd.fecha_inicio IS NOT NULL, 0, 1) ) = 0
                        AND MAX( rd.alerta_tipo ) < 2, 'Inconcluso',
                        IF( (MIN( IF( rd.dtiempo_final IS NOT NULL AND rd.fecha_inicio IS NOT NULL, 0, 1) ) = 0
                                OR MIN( IF( rd.dtiempo_final IS NULL AND rd.fecha_inicio IS NULL, 0, 1) ) = 0)
                                AND MAX( rd.alerta_tipo ) > 1, 'Trunco', 'Concluido'
                        )
                ) estado,
                GROUP_CONCAT( 
                    IF( rd.dtiempo_final IS NULL,
                        CONCAT( rd.norden,'-(',a2.nombre,')' ), NULL
                    ) ORDER BY rd.norden
                ) ult_paso,
                COUNT(rd.id) total_pasos,
                IFNULL(r.fecha_inicio,'') AS fecha_inicio,
                IF( IFNULL(tr.persona_autoriza_id,'')!='',(SELECT CONCAT(paterno,' ',materno,', ',nombre) FROM personas where id=tr.persona_autoriza_id),'' ) autoriza,
                IF( IFNULL(tr.persona_responsable_id,'')!='',(SELECT CONCAT(paterno,' ',materno,', ',nombre) FROM personas where id=tr.persona_responsable_id),'' ) responsable,
                COUNT( IF( rd.alerta=0,rd.id,NULL ) ) ok,
                COUNT( IF( rd.alerta=1,rd.id,NULL ) ) error,
                COUNT( IF( rd.alerta=2,rd.id,NULL ) ) corregido
                FROM tablas_relacion tr 
                INNER JOIN rutas r ON tr.id=r.tabla_relacion_id and r.estado=1
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id and rd.estado=1
                INNER JOIN areas a2 ON rd.area_id=a2.id
                LEFT JOIN tipo_solicitante ts ON ts.id=tr.tipo_persona and ts.estado=1
                LEFT JOIN areas a ON a.id=tr.area_id
                WHERE tr.estado=1".
                $array['ruta_flujo_id'].
                $array['fecha'].
                $array['tramite'].
                "GROUP BY r.id";

        $r= DB::select($sql);
        return $r;
    }

    public static function TramiteDetalle( $array ){
        $sql="  SELECT rd.id, rd.ruta_id, IFNULL(a.nombre,'') as area, 
                IFNULL(t.nombre,'') as tiempo, IFNULL(dtiempo,'') as dtiempo, 
                IFNULL(rd.fecha_inicio,'') as fecha_inicio, IFNULL(dtiempo_final,'') as dtiempo_final, 
                norden, alerta, alerta_tipo,
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
                SEPARATOR '|'),'') AS verbo2,
                IFNULL(GROUP_CONCAT(
                  CONCAT(
                      '<b>',
                      IFNULL(v.orden,' '),
                      '</b>',
                       '.- ',
                      IF(v.finalizo=0,'<font color=#EC2121>Pendiente</font>',CONCAT('<font color=#22D72F>Finalizó</font>(',p.paterno,' ',p.materno,', ',p.nombre,' ',IFNULL(CONCAT('<b>',v.documento,'</b>'),''),'//',IFNULL(v.observacion,''),'//',IFNULL(CONCAT('<b>',v.updated_at,'</b>'),''),')' ) )
                  )
                    ORDER BY v.orden ASC
                SEPARATOR '|'),'') AS ordenv,
                rd.archivo
                FROM rutas AS r 
                INNER JOIN rutas_detalle AS rd ON r.id = rd.ruta_id AND rd.estado = 1
                INNER JOIN rutas_detalle_verbo AS v ON rd.id = v.ruta_detalle_id AND v.estado=1
                INNER JOIN areas AS a ON rd.area_id = a.id 
                INNER JOIN tiempos AS t ON rd.tiempo_id = t.id 
                LEFT JOIN roles as ro ON v.rol_id=ro.id
                LEFT JOIN verbos as vs ON v.verbo_id=vs.id
                LEFT JOIN documentos as d ON v.documento_id=d.id
                LEFT JOIN personas as p ON v.usuario_updated_at=p.id
                WHERE r.estado = 1".
                $array['ruta_id']."
                GROUP BY rd.id";

        $set=DB::select('SET group_concat_max_len := @@max_allowed_packet');
        $r= DB::select($sql);
        
        return $r;
    }

    public static function BandejaTramiteCount( $array ){
        $sql="  SELECT count(DISTINCT(rd.id)) cant
                FROM rutas r
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1 AND rd.condicion=0
                INNER JOIN tablas_relacion tr ON r.tabla_relacion_id=tr.id AND tr.estado=1
                INNER JOIN flujos f ON f.id=r.flujo_id
                ".$array['referido']." JOIN referidos re ON re.ruta_detalle_id=rd.ruta_detalle_id_ant and re.estado=1
                WHERE r.estado=1 
                AND rd.fecha_inicio<=CURRENT_TIMESTAMP()
                AND rd.fecha_inicio IS NOT NULL ".
                $array['w'].
                $array['areas'].
                $array['id_union'].
                $array['id_ant'].
                $array['solicitante'].
                $array['proceso'].
                $array['tiempo_final'];
        $r= DB::select($sql);
        return $r[0]->cant;
    }

    public static function BandejaTramite( $array ){
        $sql="  SELECT
                tr.id_union,
                rd.id ruta_detalle_id,
                rd.ruta_id ruta_id,
                CONCAT(t.apocope,': ',rd.dtiempo) tiempo,
                IFNULL(rd.fecha_inicio,'') fecha_inicio,
                rd.norden,
                r.fecha_inicio fecha_tramite,
                rd.estado_ruta AS estado_ruta,
                (   SELECT COUNT(id)
                    FROM visualizacion_tramite vt
                    WHERE vt.ruta_detalle_id=rd.id
                    AND vt.usuario_created_at=".$array['usuario']."
                ) id,
                f.nombre proceso,
                re.referido id_union_ant,
                CASE tr.tipo_persona
                WHEN 1 or 6 THEN CONCAT(tr.paterno,' ',tr.materno,', ',tr.nombre)
                WHEN 2 THEN CONCAT(tr.razon_social,' | RUC:',tr.ruc)
                WHEN 4 or 5 THEN tr.razon_social
                WHEN 3 THEN (SELECT nombre FROM areas WHERE id=tr.area_id)
                ELSE ''
                END persona,
                IF( 
                    IFNULL(rd.fecha_proyectada,CURRENT_TIMESTAMP())>=CURRENT_TIMESTAMP(),'<div style=\"background: #00DF00;color: white;\">Dentro del Tiempo</div>','<div style=\"background: #FE0000;color: white;\">Fuera del Tiempo</div>'
                ) tiempo_final,
                IF( 
                    IFNULL(rd.fecha_proyectada,CURRENT_TIMESTAMP())>=CURRENT_TIMESTAMP(),'Dentro del Tiempo','Fuera del Tiempo'
                ) tiempo_final_n
                FROM rutas r
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1 AND rd.condicion=0
                INNER JOIN tablas_relacion tr ON r.tabla_relacion_id=tr.id AND tr.estado=1
                INNER JOIN tiempos t ON t.id=rd.tiempo_id
                INNER JOIN flujos f ON f.id=r.flujo_id
                ".$array['referido']." JOIN 
                referidos re ON re.ruta_detalle_id=rd.ruta_detalle_id_ant and re.estado=1
                WHERE r.estado=1 
                AND rd.fecha_inicio<=CURRENT_TIMESTAMP()
                AND rd.fecha_inicio IS NOT NULL ".
                $array['w'].
                $array['areas'].
                $array['id_union'].
                $array['id_ant'].
                $array['solicitante'].
                $array['proceso'].
                $array['tiempo_final'].
                $array['order'].
                $array['limit'];
                //ORDER BY rd.fecha_inicio DESC
       $r= DB::select($sql);
        return $r;
    }
    
        public static function BandejaTramiteAreaCount( $array ){
        $sql="  SELECT count(DISTINCT(rd.id)) cant
                FROM rutas r
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1 AND rd.condicion=0
                INNER JOIN tablas_relacion tr ON r.tabla_relacion_id=tr.id AND tr.estado=1
                INNER JOIN tiempos t ON t.id=rd.tiempo_id 
                INNER JOIN flujos f ON f.id=r.flujo_id
                LEFT JOIN carta_desglose cd ON cd.ruta_detalle_id=rd.id
        LEFT JOIN personas p1 ON p1.id=cd.persona_id
                ".$array['referido']." JOIN referidos re ON re.ruta_detalle_id=rd.ruta_detalle_id_ant and re.estado=1
                WHERE r.estado=1 
                AND rd.fecha_inicio!='' ".
                $array['w'].
                $array['areas'].
                $array['id_union'].
                $array['id_ant'].
                $array['solicitante'].
                $array['proceso'].
                $array['tiempo_final'];
        $r= DB::select($sql);
        return $r[0]->cant;
    }

    public static function BandejaTramiteArea( $array ){
        $sql="  SELECT
                CONCAT_WS(' ',p1.paterno,p1.materno,p1.nombre)as responsable,
                tr.id_union,
                rd.id ruta_detalle_id,
                rd.ruta_id ruta_id,
                CONCAT(t.apocope,': ',rd.dtiempo) tiempo,
                IFNULL(rd.fecha_inicio,'') fecha_inicio,
                rd.norden,
                r.fecha_inicio fecha_tramite,
                rd.estado_ruta AS estado_ruta,
                (   SELECT COUNT(id)
                    FROM visualizacion_tramite vt
                    WHERE vt.ruta_detalle_id=rd.id
                    AND vt.usuario_created_at=".$array['usuario']."
                ) id,
                f.nombre proceso,
                re.referido id_union_ant,
                IF(tr.tipo_persona=1 or tr.tipo_persona=6,
                    CONCAT(tr.paterno,' ',tr.materno,', ',tr.nombre),
                    IF(tr.tipo_persona=2,
                        CONCAT(tr.razon_social,' | RUC:',tr.ruc),
                        IF(tr.tipo_persona=3,
                            (SELECT nombre FROM areas WHERE id=tr.area_id),
                            IF(tr.tipo_persona=4 or tr.tipo_persona=5,
                                tr.razon_social,''
                            )
                        )
                    )
                ) AS persona,
                IF( 
                    IF( rd.fecha_proyectada is not null, rd.fecha_proyectada, 
                        CalcularFechaFinal(
                            rd.fecha_inicio, 
                            (rd.dtiempo*t.totalminutos),
                            rd.area_id
                        )
                    )>=CURRENT_TIMESTAMP(),'<div style=\"background: #00DF00;color: white;\">Dentro del Tiempo</div>','<div style=\"background: #FE0000;color: white;\">Fuera del Tiempo</div>'
                ) tiempo_final,
                IF( 
                    IF( rd.fecha_proyectada is not null, rd.fecha_proyectada, 
                        CalcularFechaFinal(
                            rd.fecha_inicio, 
                            (rd.dtiempo*t.totalminutos),
                            rd.area_id
                        )
                    )>=CURRENT_TIMESTAMP(),'Dentro del Tiempo','Fuera del Tiempo'
                ) tiempo_final_n
                FROM rutas r
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1 AND rd.condicion=0
                INNER JOIN tablas_relacion tr ON r.tabla_relacion_id=tr.id AND tr.estado=1
                INNER JOIN tiempos t ON t.id=rd.tiempo_id
                INNER JOIN flujos f ON f.id=r.flujo_id
                LEFT JOIN personas p1 ON p1.id=rd.persona_responsable_id
                ".$array['referido']." JOIN 
                referidos re ON re.ruta_detalle_id=rd.ruta_detalle_id_ant and re.estado=1
                WHERE r.estado=1 
                AND rd.fecha_inicio<=CURRENT_TIMESTAMP()
                AND rd.fecha_inicio!='' ".
                $array['w'].
                $array['areas'].
                $array['id_union'].
                $array['id_ant'].
                $array['solicitante'].
                $array['proceso'].
                $array['tiempo_final'].
                $array['limit'];
                //ORDER BY rd.fecha_inicio DESC
       $r= DB::select($sql);
        return $r;
    }

    public static function TramitePendiente( $array ){
        $detalle="";$qsqlDet="";
        $r=array();
        $sqlCab="   SELECT IF(a.nemonico!='',a.nemonico,a.nombre) area,a.id
                    FROM rutas r
                    INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1 AND rd.condicion=0
                    INNER JOIN areas a ON a.id=r.area_id
                    WHERE r.estado=1 
                    AND rd.fecha_inicio!='' 
                    AND rd.dtiempo_final IS NULL
                    ".$array['area'].
                    $array['fecha']."
                    GROUP BY a.id
                    ORDER BY a.nombre DESC";
        $qsqlCab=DB::select($sqlCab);

        for ($i=0; $i < count($qsqlCab); $i++) { 
            $detalle.=" ,COUNT( IF(r.area_id=".$qsqlCab[$i]->id.",r.area_id,NULL) ) area_id_".$qsqlCab[$i]->id."
                        ,COUNT( IF(r.area_id=".$qsqlCab[$i]->id." AND 
                                    CalcularFechaFinal(
                                    rd.fecha_inicio, 
                                    (rd.dtiempo*t.totalminutos),
                                    rd.area_id
                                    )<CURRENT_TIMESTAMP(),
                                    r.area_id,NULL
                                    ) 
                        ) area_id_".$qsqlCab[$i]->id."_in";
            array_push($r,$qsqlCab[$i]->id."|".$qsqlCab[$i]->area);
        }

        $qsqlDet="  SELECT a.nombre area,f.nombre proceso,COUNT(rd.area_id) total, COUNT(DISTINCT(r.area_id)) total_area,
                    COUNT( 
                        IF(
                            CalcularFechaFinal(
                            rd.fecha_inicio, 
                            (rd.dtiempo*t.totalminutos),
                            rd.area_id
                            )<CURRENT_TIMESTAMP(),r.area_id,NULL
                        )
                    ) total_in
                    $detalle 
                    FROM rutas r
                    INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1 AND rd.condicion=0
                    INNER JOIN flujos f ON f.id=r.flujo_id
                    INNER JOIN tiempos t ON t.id=rd.tiempo_id
                    INNER JOIN areas a ON a.id=rd.area_id
                    WHERE r.estado=1 
                    AND rd.fecha_inicio!='' 
                    AND rd.dtiempo_final IS NULL
                    ".$array['area'].
                    $array['fecha']."
                    GROUP BY rd.area_id".$array['sino']." WITH ROLLUP";
        $qsqlDet=DB::select($qsqlDet);

        $rf[0]=$r;
        $rf[1]=$qsqlDet;
        $rf[2]=$array['sino'];
        return $rf;
    }

    public static function BandejaTramiteEnvioAlertas( $array ){
        $sql="  SELECT
                tr.id_union,r.id ruta_id,
                rd.id ruta_detalle_id,
                CONCAT(t.apocope,': ',rd.dtiempo) tiempo,
                IFNULL(rd.fecha_inicio,'') fecha_inicio,
                rd.norden,
                rd.estado_ruta AS estado_ruta,
                f.nombre proceso, a.nemonico, 
                CONCAT(p.paterno,' ',p.materno,', ',p.nombre) responsable, 
                p.email_mdi,p.email,p.rol_id,
                IFNULL(
                (   SELECT CONCAT(a.fecha,'|',a.tipo)
                    FROM alertas a
                    WHERE a.ruta_detalle_id=rd.id
                    AND a.persona_id=p.id
                    AND a.estado=1 
                    ORDER BY a.id DESC
                    LIMIT 0,1
                ),'|' ) alerta, p.id persona_id, p2.id jefe_id,
                CONCAT(p2.paterno,' ',p2.materno,', ',p2.nombre) jefe,
                p2.email_mdi email_jefe,
                CONCAT(p3.paterno,' ',p3.materno,', ',p3.nombre) responsable_auto, 
                p3.email_mdi email_mdi_responsable_auto,
                p3.email email_responsable_auto,
                p3.id responsable_auto_id,
                (
                    SELECT CONCAT(email,',',email_mdi)
                    FROM personas 
                    WHERE area_id=31
                    AND rol_id=8
                    AND estado=1
                    LIMIT 0,1
                ) email_seguimiento
                FROM rutas r
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1 AND rd.condicion=0
                INNER JOIN areas a ON a.id=rd.area_id
                INNER JOIN personas p ON p.id=rd.persona_responsable_id
                INNER JOIN personas p2 ON p2.area_id=a.id AND FIND_IN_SET(p2.rol_id,'8,9') AND p2.estado=1
                INNER JOIN tablas_relacion tr ON r.tabla_relacion_id=tr.id AND tr.estado=1
                INNER JOIN tiempos t ON t.id=rd.tiempo_id
                INNER JOIN flujos f ON f.id=r.flujo_id
                LEFT JOIN personas p3 ON p3.area_id=a.id AND p3.estado=1 AND p3.responsable_dert=1
                WHERE r.estado=1 
                AND rd.fecha_inicio!='' 
                AND rd.dtiempo_final IS NULL ".
                $array['tiempo_final'].
                " ORDER BY rd.fecha_inicio DESC ".
                $array['limit'];
        $r= DB::select($sql);
        return $r;
    }

    public static function ProcesosyActividades(){
        $sql = "SELECT rfd.usuario_updated_at norden,f.nombre proceso,CONCAT_WS(' ',p.nombre,p.paterno,p.materno) nombdueño,a.nombre areanom, 
            CASE rf.estado
                WHEN 1 THEN 'Produccion'
                WHEN 2 THEN 'Pendiente'
            END AS estado,rf.created_at as fechacreacion,
            rfd.norden paso,a2.nombre nombareapaso,CONCAT(rfd.dtiempo,LOWER(t.apocope)) tiempo,CONCAT_WS(' ',p2.nombre,p2.paterno,p2.materno) usuarioupdate,rfd.updated_at fechaupdate
             from flujos f 
            INNER JOIN rutas_flujo rf on rf.flujo_id=f.id AND rf.estado in (1,2) 
            INNER JOIN rutas_flujo_detalle rfd on rfd.ruta_flujo_id=rf.id and rfd.estado=1 
            INNER JOIN areas a on a.id=rf.area_id
            INNER JOIN areas a2 on a2.id=rfd.area_id  
            INNER JOIN personas p on p.id=rf.persona_id
            INNER JOIN personas p2 on p2.id=rfd.usuario_updated_at 
            INNER JOIN tiempos t on t.id=rfd.tiempo_id";

        if(Input::get('area_id')){
            $sql.=' AND rfd.area_id IN ("'.Input::get('area_id').'") ';
        }

        if(Input::get('estado')){
            $sql.=' AND rf.estado IN ("'.Input::get('estado').'") ';
        }

        $sql.=' ORDER BY proceso asc, paso asc';

        $r= DB::select($sql);
        return $r;
    }

    public static function Docplataforma(){
    $fecha = Input::get('fecha');
      $area_filtro="";$fecha_filtro="";
      if( Input::get('area_id')!='' ){
        $areaId = implode(",",Input::get('area_id'));
        $area_filtro= " AND FIND_IN_SET(rd2.area_id,'".$areaId."')>0 ";
      }

      if(Input::get('areaexport')!=''){
        $area_filtro= " AND FIND_IN_SET(rd2.area_id,'".Input::get('areaexport')."')>0 ";
      }
      if( Input::get('fecha')!='' ){
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $fecha_filtro="AND DATE(r.fecha_inicio) BETWEEN '$fechaIni' AND '$fechaFin'";
      }else {
          
      $estadofinal="<CURRENT_TIMESTAMP()";
      $datehoy=date("Y-m-d");
      $datesp=date("Y-m-d",strtotime("-15 days")); 
      $fecha_filtro="  AND CalcularFechaFinal(
                                rd.fecha_inicio, 
                                (1440+ IF(TIME(rd.fecha_inicio)>'14:00:00',1110,240)),
                                rd.area_id 
                                )$estadofinal 
                                AND DATE(rd.fecha_inicio) BETWEEN '$datesp' AND '$datehoy' 
                                AND ValidaDiaLaborable('$datehoy',rd.area_id)=0 AND ISNULL(f2.nombre)";

       
      }
      $sql="SELECT tr2.id_union norden,f.nombre proceso_pla, a.nombre area,tr.id_union plataforma,r.fecha_inicio,rd2.dtiempo_final
            ,f2.nombre proceso,r2.fecha_inicio fecha_inicio_gestion, rd2f.norden ult_paso
            ,IFNULL(rd3f.norden,rd2f.norden) act_paso, 
            IFNULL(DATE_ADD(r2.fecha_inicio, INTERVAL t.totalminutos MINUTE),DATE_ADD(r2.fecha_inicio, INTERVAL t2.totalminutos MINUTE)) fecha_fin
            ,IFNULL(rd3f.dtiempo_final,rd2f.dtiempo_final) tiempo_realizado
            FROM rutas r
            INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1 AND rd.norden=1 AND rd.area_id=52
            INNER JOIN rutas_detalle rd2 ON rd2.ruta_id=r.id AND rd2.estado=1 AND rd2.norden=2
            INNER JOIN personas p ON (rd2.area_id=p.area_id OR FIND_IN_SET(rd2.area_id,p.area_responsable)) AND p.rol_id IN (8,9) AND p.estado=1
            INNER JOIN areas a ON a.id=rd2.area_id 
            INNER JOIN tablas_relacion tr ON tr.id=r.tabla_relacion_id AND tr.estado=1 AND tr.usuario_created_at!=1272
            INNER JOIN flujos f ON f.id=r.flujo_id
            LEFT JOIN tablas_relacion tr2 ON tr2.id_union=tr.id_union AND tr2.estado=1 AND tr2.id>tr.id
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
            $fecha_filtro
            $area_filtro";

            if(Input::has('tipo_tramite')){
                if(Input::get('tipo_tramite') == 1){ //con gestion
                    $sql.=" AND tr2.id_union IS NOT NULL";
                }elseif(Input::get('tipo_tramite') == 2){ //sin gestion
                    $sql.=" AND tr2.id_union IS NULL";
                }
            }
            $sql.=" order by a.nombre,proceso DESC,rd.dtiempo_final";

            $r=DB::select($sql);
            return $r;
    }
    
    public static function Docplataformaalertaenvio(){
    $fecha = Input::get('fecha');
      $area_filtro="";$fecha_filtro="";
      if( Input::get('area_id')!='' ){
        $areaId = implode(",",Input::get('area_id'));
        $area_filtro= " AND FIND_IN_SET(rd2.area_id,'".$areaId."')>0 ";
      }

      if(Input::get('areaexport')!=''){
        $area_filtro= " AND FIND_IN_SET(rd2.area_id,'".Input::get('areaexport')."')>0 ";
      }
      if( Input::get('fecha')!='' ){
        list($fechaIni,$fechaFin) = explode(" - ", $fecha);
        $fecha_filtro="AND r.fecha_inicio BETWEEN '$fechaIni' AND '$fechaFin'";
      }else {
          
      $estadofinal="<CURRENT_TIMESTAMP()";
      $datehoy=date("Y-m-d");
      $datesp=date("Y-m-d",strtotime("-15 days")); 
      $fecha_filtro="  AND CalcularFechaFinal(
                                rd2.fecha_inicio, 
                                (1440+ IF(TIME(rd.fecha_inicio)>'14:00:00',1110,240)),
                                rd2.area_id 
                                )$estadofinal 
                                AND DATE(rd2.fecha_inicio) BETWEEN '$datesp' AND '$datehoy' 
                                AND ValidaDiaLaborable('$datehoy',rd2.area_id)=0 AND ISNULL(r2.id)";

       
      }
      $sql="SELECT CONCAT_WS(' ',p.paterno,p.materno,p.nombre) persona,p.email_mdi,p.email, a.nombre area,tr.id_union plataforma,r.id ruta_id,rd2.id ruta_detalle_id,p.id persona_id,
                        IFNULL(
                (   SELECT CONCAT(a.fecha,'|',a.tipo)
                    FROM alertas a
                    WHERE a.ruta_detalle_id=rd2.id
                    AND a.persona_id=p.id
                    AND a.estado=1 
                    ORDER BY a.id DESC
                    LIMIT 0,1
                ),'|' ) alerta,
                
                (
                    SELECT CONCAT(email,',',email_mdi)
                    FROM personas 
                    WHERE area_id=31
                    AND rol_id=8
                    AND estado=1
                    LIMIT 0,1
                ) email_seguimiento
            FROM rutas r
            INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1 AND rd.norden=1 AND rd.area_id=52
            INNER JOIN rutas_detalle rd2 ON rd2.ruta_id=r.id AND rd2.estado=1 AND rd2.norden=2
            INNER JOIN personas p ON rd2.area_id=p.area_id AND p.rol_id IN (8,9) AND p.estado=1
            INNER JOIN areas a ON a.id=rd2.area_id
            INNER JOIN tablas_relacion tr ON tr.id=r.tabla_relacion_id AND tr.estado=1 AND tr.usuario_created_at!=1272
            LEFT JOIN tablas_relacion tr2 ON tr2.id_union=tr.id_union AND tr2.estado=1 AND tr2.id>tr.id
            LEFT JOIN rutas r2 ON r2.tabla_relacion_id=tr2.id AND r2.estado=1
            WHERE r.estado=1
            $fecha_filtro
            $area_filtro";
            $r=DB::select($sql);
            return $r;
    }
    
    public static function getExpedienteUnico(){
            $referido=Referido::where('ruta_id', '=', Input::get('ruta_id'))->firstOrFail();
      /*  if(Input::get('ruta_detalle_id')){*/
            if($referido){
                $data = [];
                $sql = "SELECT re.ruta_id,re.ruta_detalle_id,re.referido,re.fecha_hora_referido fecha_hora,f.nombre proceso,a.nombre area,re.norden, 'r' tipo,re.doc_digital_id 
                        FROM referidos re 
                        INNER JOIN rutas r ON re.ruta_id=r.id 
                        INNER JOIN flujos f ON r.flujo_id=f.id 
                        LEFT JOIN rutas_detalle rd ON re.ruta_detalle_id=rd.id
                        LEFT JOIN areas a ON rd.area_id=a.id  
                        WHERE re.tabla_relacion_id='".$referido->tabla_relacion_id."'
                        UNION
                        SELECT re.ruta_id,re.ruta_detalle_id,sustento,fecha_hora_sustento fecha_hora,f.nombre proceso,a.nombre area,rd.norden,'s' tipo,null as doc_digital_id
                        FROM sustentos s
                        INNER JOIN referidos re ON re.id=s.referido_id AND re.tabla_relacion_id='".$referido->tabla_relacion_id."'
                        INNER JOIN rutas_detalle rd ON rd.id=s.ruta_detalle_id
                        LEFT JOIN areas a ON rd.area_id=a.id  
                        INNER JOIN rutas r ON re.ruta_id=r.id 
                        INNER JOIN flujos f ON r.flujo_id=f.id
                        ORDER BY ruta_id,norden,tipo";
                $r=DB::select($sql);
                return $r;                
            }else{
                return false;
            }
       /* }*/
    }
        public static function CuadroProceso() {
        $sSql = '';
        $cl = '';
        $left = '';
        $f_fecha = '';
        $cabecera = [];
        $cabecera1 = [];

        if (Input::has('fecha_ini') && Input::get('fecha_ini') && Input::has('fecha_fin') && Input::get('fecha_fin')) {
            $fecha_ini=Input::get('fecha_ini');
            $fecha_fin=Input::get('fecha_fin');
            $f_fecha .= "AND DATE_FORMAT(r.fecha_inicio,'%Y-%m-%d') BETWEEN '" . $fecha_ini . "' AND '" . $fecha_fin . "' ";
        }

        $fecha_ini = substr($fecha_ini, 0, 7);
        $n = 1;
        for($i=$fecha_ini;$i<=$fecha_fin;$i = date("Y-m", strtotime($i ."+ 1 month"))){
            $cl .= ",count(DISTINCT(r$n.id)) r$n";
            $cl .= ",count(DISTINCT(IF(ISNULL(rd$n.dtiempo_final),r$n.id,NULL))) p$n";
            $left .= "LEFT JOIN rutas r$n on r$n.id=r.id AND DATE_FORMAT(r$n.fecha_inicio,'%Y-%m')='".$i."'";
            $left .= " LEFT JOIN rutas_detalle rd$n on r$n.id=rd$n.ruta_id AND  rd$n.estado=1 ";
            $n++;
            array_push($cabecera,$i);
            array_push($cabecera1, 'N° de P.');
        }

        $sSql .= "SELECT 1 as norden";   
        if(Input::get('sino')==1){
            $sSql.=",a.nombre as area";
        }     
        $sSql .= ",rf.id as ruta_flujo_id,f.nombre as proceso";
        $sSql .= $cl;
        $sSql .= ",count(DISTINCT(r.id))  rt
                ,count(DISTINCT(IF(ISNULL(rd.dtiempo_final),r.id,NULL))) pt
                ,count( DISTINCT( IF(rd.alerta>0,r.id,NULL) ) ) ft
                ,count(DISTINCT(rfd.area_id)) areas
                ,count( DISTINCT( IF( rd.alerta>0,rd.area_id,NULL ) ) ) alertas";
        $sSql .= " FROM flujos f
                    INNER JOIN categorias c ON c.id=f.categoria_id AND tipo=1
                    INNER JOIN rutas_flujo rf ON rf.flujo_id=f.id AND rf.estado=1
                    INNER JOIN rutas_flujo_detalle rfd ON rfd.ruta_flujo_id=rf.id AND rfd.estado=1
                    INNER JOIN rutas_flujo_detalle rfd2 ON rfd2.ruta_flujo_id=rf.id AND rfd2.norden=1 AND rfd2.estado=1
                    INNER JOIN areas a on a.id=rfd2.area_id 
                    LEFT JOIN rutas r ON r.ruta_flujo_id=rf.id AND r.estado=1 ".$f_fecha.
                    " LEFT JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1 ";
        $sSql .=$left;
        $sSql.="WHERE f.estado=1 ";
        if (Input::has('area_id') && Input::get('area_id')) {
            $id_area = Input::get('area_id');
            $sSql .= " AND a.id IN ($id_area)";
        }
            $sSql .= " GROUP BY rf.id "; 
        
        
        $oData['cabecera'] = $cabecera;
        $oData['cabecera1'] = $cabecera1;
        $oData['data'] = DB::select($sSql);
        $oData['sino'] = Input::get('sino');
        return $oData;
    }
    public static function DetalleCuadroProceso() {
        $sSql = '';
        $sSql.="SELECT f.nombre flujo,a.nombre area,rd.norden, count( DISTINCT(r.id) ) total, count( IF(rd.alerta>0,r.id,NULL) ) tf
                FROM flujos f 
                INNER JOIN rutas_flujo rf ON rf.flujo_id=f.id AND rf.estado=1
                INNER JOIN rutas r ON r.ruta_flujo_id=rf.id AND r.estado=1 AND DATE_FORMAT(r.fecha_inicio,'%Y-%m') BETWEEN '".Input::get('fecha_ini')."' AND '".Input::get('fecha_fin')."'
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1
                INNER JOIN areas a ON a.id=rd.area_id
                WHERE f.estado=1";
        $sSql.=" AND rf.id=".Input::get('ruta_flujo_id');
        $sSql.=" GROUP BY rd.area_id,rd.norden
                ORDER BY rd.norden";
        $r=DB::select($sSql);
        return $r;
    }
    
    public static function ReporteTramite( $array )
    {
        $sql =" SELECT  CalcularFechaFinal(
                                rd2.fecha_inicio,
                                (rd2.dtiempo*1440),
                                rd2.area_id 
                                ) as fecha_valida,IFNULL(trr.sumilla,'') as sumilla_referido,trr.fecha_tramite fecha_inicio_referido,trr.id_union tramite_referido,tr.id_union AS tramite, r.id, r.ruta_flujo_id, 
                ts.nombre AS tipo_persona,
                IF(trr.tipo_persona=1 or trr.tipo_persona=6,
                    CONCAT(IFNULL(trr.paterno,''),' ',IFNULL(trr.materno,''),', ',IFNULL(trr.nombre,'')),
                    IF(trr.tipo_persona=2,
                        CONCAT(trr.razon_social,' | RUC:',trr.ruc),
                        IF(trr.tipo_persona=3,
                            a.nombre,
                            IF(trr.tipo_persona=4 or trr.tipo_persona=5,
                                trr.razon_social,''
                            )
                        )
                    )
                ) AS persona_referido,
                IF(tr.tipo_persona=1 or tr.tipo_persona=6,
                    CONCAT(IFNULL(tr.paterno,''),' ',IFNULL(tr.materno,''),', ',IFNULL(tr.nombre,'')),
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
                IF( MIN( IF( rd.dtiempo_final IS NULL AND rd.fecha_inicio IS NOT NULL, 0, 1) ) = 0
                        AND MAX( rd.alerta_tipo ) < 2, 'Inconcluso',
                        IF( (MIN( IF( rd.dtiempo_final IS NOT NULL AND rd.fecha_inicio IS NOT NULL, 0, 1) ) = 0
                                OR MIN( IF( rd.dtiempo_final IS NULL AND rd.fecha_inicio IS NULL, 0, 1) ) = 0)
                                AND MAX( rd.alerta_tipo ) > 1, 'Trunco', 'Concluido'
                        )
                ) estado,
                GROUP_CONCAT( 
                    IF( rd.dtiempo_final IS NULL,
                        CONCAT( rd.norden,' (',a2.nombre,')','|',rd.fecha_inicio ), NULL
                    ) ORDER BY rd.norden
                ) ult_paso,
                MAX(rd.norden) total_pasos,
                IF( IFNULL(tr.persona_autoriza_id,'')!='',(SELECT CONCAT(paterno,' ',materno,', ',nombre) FROM personas where id=tr.persona_autoriza_id),'' ) autoriza,
                IF( IFNULL(tr.persona_responsable_id,'')!='',(SELECT CONCAT(paterno,' ',materno,', ',nombre) FROM personas where id=tr.persona_responsable_id),'' ) responsable,
                COUNT( IF( rd.alerta=0,rd.id,NULL ) ) ok,
                COUNT( IF( rd.alerta=1,rd.id,NULL ) ) error,
                COUNT( IF( rd.alerta=2,rd.id,NULL ) ) corregido
                FROM tablas_relacion tr 
                INNER JOIN rutas r ON tr.id=r.tabla_relacion_id and r.estado=1
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id and rd.estado=1
                INNER JOIN areas a2 ON rd.area_id=a2.id
                LEFT JOIN rutas_detalle rd2 ON rd2.ruta_id=r.id and rd2.estado=1 AND ISNULL(rd2.dtiempo_final) AND rd2.fecha_inicio!=''
                LEFT JOIN referidos re ON re.ruta_id=r.id and re.tipo=0
                LEFT JOIN tablas_relacion trr ON trr.id=re.tabla_relacion_id
                LEFT JOIN tipo_solicitante ts ON ts.id=tr.tipo_persona and ts.estado=1
                LEFT JOIN areas a ON a.id=tr.area_id
                WHERE tr.estado=1".
                $array['ruta_flujo_id'].
                $array['fecha'].
                $array['tramite'].
                "GROUP BY r.id";

        $r= DB::select($sql);
        return $r;
    }

    // Reporte de Tramite Actividades
    public static function VerNroPasosTramite($array)
    {
        $sSql = '';
        $sSql.="SELECT DISTINCT(rd.norden) cant
                FROM rutas r 
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id";
        $sSql .=" WHERE r.estado=1 ".
                $array['ruta_flujo_id'].
                $array['fecha'];
        $r=DB::select($sSql);
        return $r;
    }

    public static function ReporteTramiteActividad( $array, $data )
    {
        $cabecera = [];
        $sql =" SELECT r.id, tr.sumilla, tr.id_union ";

        foreach ($data as $i => $lis) 
        {
            $sql .=", GROUP_CONCAT(
                        CONCAT( a$i.nemonico,' => D: ',rd$i.dtiempo, 
                            IF( ISNULL(rd$i.fecha_inicio),
                                '|B|<br>',
                                IF( rd$i.dtiempo_final!='' AND rd$i.fecha_inicio!='' AND rd$i.alerta=0 AND rd$i.alerta_tipo=0, 
                                    CONCAT('|V|<br>',rd$i.fecha_inicio,'<br>',rd$i.dtiempo_final),
                                    IF( rd$i.dtiempo_final!='' AND rd$i.fecha_inicio!='' AND (rd$i.alerta!=0 OR rd$i.alerta_tipo!=0),
                                        CONCAT('|N|<br>',rd$i.fecha_inicio,'<br>',rd$i.dtiempo_final),
                                        IF( ISNULL(rd$i.dtiempo_final) AND rd$i.fecha_inicio!='' 
                                                                    AND CalcularFechaFinal(rd$i.fecha_inicio,rd$i.dtiempo*1440,rd$i.area_id)>=CURRENT_TIMESTAMP(), 
                                            CONCAT('|V|<br>',rd$i.fecha_inicio,'<br>',CalcularFechaFinal(rd$i.fecha_inicio,rd$i.dtiempo*1440,rd$i.area_id)),
                                            CONCAT('|R|<br>',rd$i.fecha_inicio,'<br>',CalcularFechaFinal(rd$i.fecha_inicio,rd$i.dtiempo*1440,rd$i.area_id))
                                        )
                                    )
                                )
                            )
                        )
                    ) act$i,rd$i.archivo as archivo$i ";

            array_push($cabecera, $lis->cant);
        }

        $sql .="FROM rutas r
                INNER JOIN tablas_relacion tr ON tr.id=r.tabla_relacion_id AND tr.estado=1
                INNER JOIN rutas_detalle rd ON rd.ruta_id = r.id AND rd.estado=1";        
        foreach ($data as $i => $lis) 
        {
            $sql .=" LEFT JOIN rutas_detalle rd$i ON rd$i.ruta_id = r.id AND rd$i.norden='".$lis->cant."' AND rd$i.condicion = 0  AND rd$i.estado=1
                     LEFT JOIN areas a$i ON a$i.id = rd$i.area_id ";
        }

        $sql .=" WHERE r.estado=1 ".
                $array['ruta_flujo_id'].
                $array['fecha'].
                $array['tramite'].
                " GROUP BY r.id ";

        $oData['cabecera'] = $cabecera;
        $oData['data'] = DB::select($sql);
        return $oData;
    }

    public static function CalcularTotalesXNumeroOrden( $array )
    {
        $sql =" SELECT rd.norden, 
                COUNT(IF(rd.fecha_inicio!='' AND rd.dtiempo_final IS NULL,rd.id,NULL)) cant
                FROM rutas r
                INNER JOIN rutas_detalle rd ON r.id = rd.ruta_id
                INNER JOIN areas a ON a.id = rd.area_id ";
        $sql .=" WHERE r.estado=1
                 AND rd.estado=1
                 AND rd.condicion = 0  ".
                $array['ruta_flujo_id'].
                $array['fecha'].
                " GROUP BY rd.norden ";

        $oData['cabecera'] = array();
        $oData['data'] = DB::select($sql);
        return $oData;
    }

    public static function verArchivosDesmontesMotorizado( $array )
    {
        $sql =" SELECT rd.id, rd.archivo
                FROM rutas_detalle rd ";
        $sql .=" WHERE rd.estado=1 ".
                $array['ruta_id'];

        $oData['data'] = DB::select($sql);
        return $oData;
    }

    public static function verOrdenesTrabajo( $array )
    {
        $sql =" SELECT ap.id, CONCAT_WS(' ', p.paterno, p.materno, p.nombre) as personal, ap.actividad, ap.fecha_inicio, ap.dtiempo_final
                FROM actividad_personal ap
                INNER JOIN personas p ON ap.persona_id = p.id ";
        $sql .=" WHERE ap.estado = 1 AND ap.tipo = 2 ".
                $array['ruta_detalle_id'];
        //echo $sql;
        $oData['data'] = DB::select($sql);
        return $oData;
    }

    public static function verMapaDesmontesMotorizado( $array )
    {
        $sSql = "SELECT rd.id, rd.ruta_id, tr.id_union, tr.fecha_tramite, rd.area_id, rd.fecha_inicio, ci.id as carga_incidencia_id,
                            ci.foto, ci.direccion, ci.tipo, ci.viapredio, ci.latitud, ci.longitud, rdm.id as rdm_id, rdm.fecha_programada,
                            rdm.vehiculo_id,rdm.persona_id,CONCAT_WS(' ',p.nombre,p.paterno,p.materno) as persona
                    FROM carga_incidencias ci
                    INNER JOIN rutas r ON ci.ruta_id = r.id AND r.estado = 1
                    INNER JOIN tablas_relacion tr ON r.tabla_relacion_id = tr.id AND tr.estado = 1
                    INNER JOIN rutas_detalle rd ON r.id = rd.ruta_id AND rd.estado = 1
                    LEFT JOIN rutas_detalle_mapas rdm ON r.id = rdm.ruta_id AND rd.id = rdm.ruta_detalle_id
                    LEFT JOIN personas p ON p.id=rdm.persona_id                    
                    WHERE ci.tipo = 'DESMONTE'
                        -- AND rd.fecha_inicio IS NOT NULL
                        AND rd.dtiempo_final IS NULL ";
        $sSql .= $array['ruta_id'];

        $oData['data'] = DB::select($sSql);
        return $oData;
    }

    public static function CalcularTotalActividad( $array )
    {
        //$cabecera = [];
        $sql =" SELECT rd.area_id, a.nombre, rd.norden, 
                COUNT(IF(rd.fecha_inicio!='' AND rd.dtiempo_final IS NULL,rd.id,NULL)) cant
                FROM rutas r
                INNER JOIN rutas_detalle rd ON r.id = rd.ruta_id
                INNER JOIN areas a ON a.id = rd.area_id ";
        $sql .=" WHERE r.estado=1
                 AND rd.estado=1
                 AND rd.condicion = 0  ".
                $array['ruta_flujo_id'].
                $array['fecha'].
                " GROUP BY rd.area_id, rd.norden ASC WITH ROLLUP ";

        $oData['cabecera'] = array();
        $oData['data'] = DB::select($sql);
        return $oData;
    }
    
        public static function getPersonalizado(){
        $fecha='';
        if(Input::has('fechames')){
            $fecha="and DATE_FORMAT(tr.fecha_tramite,'%Y-%m')='".Input::get('fechames')."'";
        }else{
            $fecha="and DATE(tr.fecha_tramite) BETWEEN '".Input::get('fecha_ini')."'   AND '".Input::get('fecha_fin')."'";
        }
        $sql = "SELECT rd.id, IFNULL(MAX(rd.detalle),'') as detalle,f.id as flujo_id,f.nombre as flujo,rd.norden,a.nombre as area,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NULL and rd.fecha_inicio IS NOT NULL and rd.archivado!=2,rd.id,null)) AS pendiente,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NOT NULL AND rd.archivado=2,rd.id,null)) AS atendido,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NOT NULL AND rd.archivado=2,rd.id,null)) AS finalizo,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NOT NULL AND rd.archivado!=2 AND rd.alerta_tipo=1 AND rd.alerta=1,rd.id,null)) AS destiempo_a,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NULL and rd.fecha_inicio IS NOT NULL and rd.archivado!=2 and CURRENT_TIMESTAMP()>rd.fecha_proyectada,rd.id,null)) AS destiempo_p,
                COUNT(DISTINCT rd.ruta_flujo_id) AS cant_flujo,
                GROUP_CONCAT(DISTINCT rd.ruta_flujo_id) AS ruta_flujo_id_dep,
                COUNT(DISTINCT IF(rd.fecha_inicio IS NOT NULL,rd.id,null)) AS total
                FROM tablas_relacion tr
                INNER JOIN rutas r ON r.tabla_relacion_id=tr.id and r.ruta_flujo_id=".Input::get('ruta_flujo_id')." and r.estado=1
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id and rd.estado=1 and CHARACTER_LENGTH(rd.norden)=2 and rd.condicion=0 
                INNER JOIN areas a ON a.id=rd.area_id
                INNER JOIN flujos f ON f.id=r.flujo_id
                WHERE tr.estado=1 
                ".$fecha."
                GROUP BY r.ruta_flujo_id,rd.norden";
        $r=DB::select($sql);
        return $r;                

        }
        
        public static function getPersonalizadodetalle(){
        $fecha='';
        if(Input::has('fechames')){
            $fecha="and DATE_FORMAT(tr.fecha_tramite,'%Y-%m')='".Input::get('fechames')."'";
        }else{
            $fecha="and DATE(tr.fecha_tramite) BETWEEN '".Input::get('fecha_ini')."'   AND '".Input::get('fecha_fin')."'";
        }
        $sql = "SELECT rd.id, rd.ruta_flujo_id_dep AS ruta_flujo_id_micro,IFNULL(MAX(rd.detalle),'') as detalle,rf.id as flujo_id,f.nombre as flujo,rd.norden,a.nombre as area,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NULL and rd.fecha_inicio IS NOT NULL and rd.archivado!=2,rd.id,null)) AS pendiente,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NOT NULL AND rd.archivado=2,rd.id,null)) AS atendido,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NOT NULL AND rd.archivado=2,rd.id,null)) AS finalizo,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NOT NULL AND rd.archivado!=2 AND rd.alerta_tipo=1 AND rd.alerta=1,rd.id,null)) AS destiempo_a,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NULL and rd.fecha_inicio IS NOT NULL and rd.archivado!=2 and CURRENT_TIMESTAMP()>rd.fecha_proyectada,rd.id,null)) AS destiempo_p,
                COUNT(DISTINCT rd.ruta_flujo_id) AS cant_flujo,
                GROUP_CONCAT(DISTINCT rd.ruta_flujo_id) AS ruta_flujo_id_dep,
                COUNT(DISTINCT IF(rd.fecha_inicio IS NOT NULL,rd.id,null)) AS total
                FROM tablas_relacion tr
                INNER JOIN rutas r ON r.tabla_relacion_id=tr.id and r.ruta_flujo_id=".Input::get('ruta_flujo_id')." and r.estado=1
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id and rd.estado=1 and CHARACTER_LENGTH(rd.norden)=".Input::get('length_norden')." and rd.condicion=0 and rd.ruta_flujo_id_dep IN (".Input::get('ruta_flujo_id_dep').") and SUBSTR(rd.norden,1,".Input::get('indice').")='".Input::get('norden')."'
                INNER JOIN areas a ON a.id=rd.area_id
                INNER JOIN rutas_flujo rf ON rf.id=rd.ruta_flujo_id_dep
                INNER JOIN flujos f ON f.id=rf.flujo_id
                WHERE tr.estado=1 -- 5268
                ".$fecha."
                GROUP BY rd.ruta_flujo_id_dep,rd.norden";
        $r=DB::select($sql);
        return $r;                

        }
    
                public static function getGraficodata(){
        $fecha='';
        $sql='';
        if(Input::has('fechames')){
            $fecha="and DATE_FORMAT(tr.fecha_tramite,'%Y-%m')='".Input::get('fechames')."'";
        }else{
            $fecha="and DATE_FORMAT(tr.fecha_tramite,'%Y-%m') BETWEEN '".Input::get('fecha_ini')."'   AND '".Input::get('fecha_fin')."'";
        }
        $sql.= "SELECT DAY(tr.fecha_tramite) as dia,CONCAT(
                -- CASE DAYOFWEEK(tr.fecha_tramite)
                -- WHEN 1 THEN 'Domingo' WHEN 2 THEN 'Lunes' WHEN 3 THEN 'Martes' WHEN 4 THEN 'Miércoles'
                -- WHEN 5 THEN 'Jueves' WHEN 6 THEN 'Viernes' WHEN 7 THEN 'Sábado' END,' ',
                DAY(tr.fecha_tramite)) as fecha,f.nombre as flujo,rd.norden,a.nombre as area,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NULL and rd.fecha_inicio IS NOT NULL and rd.archivado!=2,rd.id,null)) AS pendiente,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NOT NULL AND rd.archivado=2,rd.id,null)) AS atendido,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NOT NULL AND rd.archivado=2,rd.id,null)) AS finalizo,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NOT NULL AND rd.archivado!=2 AND rd.alerta_tipo=1 AND rd.alerta=1,rd.id,null)) AS destiempo_a,
                COUNT(DISTINCT IF(rd.dtiempo_final IS NULL and rd.fecha_inicio IS NOT NULL and rd.archivado!=2 and CURRENT_TIMESTAMP()>rd.fecha_proyectada,rd.id,null)) AS destiempo_p,
                COUNT(DISTINCT IF(rd.fecha_inicio IS NOT NULL,rd.id,null)) AS total
                FROM tablas_relacion tr
                INNER JOIN rutas r ON r.tabla_relacion_id=tr.id and r.ruta_flujo_id=".Input::get('ruta_flujo_id')." and r.estado=1
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id and rd.estado=1  and rd.condicion=0";
                $sql.=" and CHARACTER_LENGTH(rd.norden)=".Input::get('length_norden');
                if(Input::has('norden')){
                    $sql.=" and rd.norden='".Input::get('norden')."'";
                    
                }
                if(Input::has('length_norden') and Input::get('length_norden')!=2){
                    $sql.=" AND ruta_flujo_id_dep=".Input::get('ruta_flujo_id_micro');
                }
            
            $sql.=" INNER JOIN areas a ON a.id=rd.area_id
                INNER JOIN flujos f ON f.id=r.flujo_id
                WHERE tr.estado=1 
                ".$fecha."
                GROUP BY r.ruta_flujo_id,DATE(tr.fecha_tramite)";
        $r=DB::select($sql);
        return $r;                

        }
        
             public static function getTramiteasignacion($array){
         $sql="SELECT tr.id_union,f.nombre as flujo,rd.norden,GROUP_CONCAT(v.nombre) as verbo,GROUP_CONCAT(rdv.id) as verbo_id
                FROM tablas_relacion tr
                INNER JOIN rutas r ON r.tabla_relacion_id=tr.id AND r.estado=1
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id and rd.estado=1
                INNER JOIN rutas_detalle_verbo rdv ON rdv.ruta_detalle_id=rd.id and rdv.estado=1 and rdv.finalizo=0 and rdv.usuario_updated_at IS NULL
                INNER JOIN verbos v ON v.id=rdv.verbo_id and v.id!=1
                INNER JOIN flujos f ON f.id=r.flujo_id
                ".$array["w"].
                " and rd.fecha_inicio IS NOT NULL 
                and rd.fecha_inicio<=CURRENT_TIME()
                AND rd.dtiempo_final IS NULL
                AND rd.condicion=0
                WHERE tr.estado=1 ".
                $array["where"].
                " GROUP BY tr.id";
         $r=DB::select($sql);
         return $r;
     }
    // --
}
?>
