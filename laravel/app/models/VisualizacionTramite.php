<?php
class VisualizacionTramite extends Eloquent
{
    public $table="visualizacion_tramite";

    public static function usuarios_visualizacion( $rutaDetalleId)
    {
        $query=" SELECT CONCAT(p.paterno,' ',p.materno,' ',p.nombre) AS persona,
                vt.`created_at` AS fecha, tv.nombre AS estado
                 FROM `rutas_detalle` rd
                JOIN `visualizacion_tramite` vt
                ON rd.id=vt.`ruta_detalle_id`
                JOIN `tipo_visualizacion` tv
                ON vt.tipo_visualizacion_id=tv.`id`
                JOIN personas p
                ON vt.`usuario_created_at`=p.id
                WHERE rd.`id`='$rutaDetalleId'
                ORDER BY vt.`created_at` DESC";
        return DB::select($query);
    }
    
    public static function BandejaTramites( $input)
    {
        if ($input) {
            $where=" WHERE IF(rf.id=0,2,1) IN ('$input')";
        } else {
            $where='';
        }
        $personaId=Auth::user()->id;
        $query="SELECT *
                FROM 
                (
                    SELECT
                    IFNULL(tr.id_union,'') AS id_union,
                    IFNULL(rd.id,'') AS ruta_detalle_id,
                    IFNULL( CONCAT(t.apocope,': ',rd.dtiempo),'') AS tiempo,
                    IFNULL(rd.fecha_inicio,'') AS fecha_inicio,
                    IFNULL(rd.norden,'') AS norden,
                    IFNULL(tr.fecha_tramite,'') AS fecha_tramite,
                    IFNULL(f.nombre,'') AS nombre,
                    IFNULL(rsp.nombre,'') AS respuesta,
                    IFNULL(rspd.nombre,'') AS respuestad,
                    IFNULL(rd.observacion,'') AS observacion,
                    IFNULL(ts.nombre,'') AS tipo_solicitante,
                    IFNULL(
                        IF(tr.tipo_persona='1',
                           CONCAT(tr.paterno,' ',tr.materno,' ',tr.nombre),
                          tr.razon_social),''
                    ) AS solicitante,
                    IFNULL(rd.alerta_tipo,'') AS alerta_tipo,
                    IFNULL(rd.alerta,'') AS alerta,
                    IFNULL(rd.condicion,'') AS condicion,
                    IFNULL(rd.estado_ruta,'') AS estado_ruta,
                    (   SELECT COUNT(id)
                        FROM visualizacion_tramite vt
                        WHERE vt.usuario_created_at='$personaId' 
                        AND rd.id=vt.ruta_detalle_id
                    ) id,
                    IFNULL(tr.ruc,'') AS ruc,
                    IFNULL(tr.sumilla,'') AS sumilla,
                    IF( rd.norden=1, tr.id_union,
                        (
                        SELECT group_concat( IF(rdv2.documento='',NULL,rdv2.documento) separator '//')
                        FROM rutas_detalle_verbo rdv2
                        INNER JOIN rutas_detalle rd2 ON rd2.id=rdv2.ruta_detalle_id AND rd2.estado=1
                        WHERE rd2.ruta_id=rd.ruta_id
                        AND rdv2.estado=1
                        AND rd2.norden=(rd.norden-1)
                        )
                    ) id_union_ant
                    FROM rutas_detalle rd
                    JOIN rutas r ON rd.ruta_id=r.id and r.estado=1
                    JOIN tablas_relacion tr ON r.tabla_relacion_id=tr.id 
                    JOIN flujos f ON r.flujo_id=f.id
                    JOIN tiempos t ON rd.tiempo_id=t.id
                    JOIN tipo_solicitante ts ON tr.tipo_persona=ts.id
                    LEFT JOIN tipos_respuesta rsp ON rd.tipo_respuesta_id=rsp.id
                    LEFT JOIN tipos_respuesta_detalle rspd
                            ON rd.tipo_respuesta_detalle_id=rspd.id
                    WHERE  rd.fecha_inicio IS NOT NULL AND rd.dtiempo_final IS NULL
                    AND rd.estado=1
                    AND rd.condicion=0
                    AND rd.area_id IN (
                        SELECT a.id
                        FROM area_cargo_persona acp
                        INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                        INNER JOIN cargo_persona cp
                                ON cp.id=acp.cargo_persona_id AND cp.estado=1
                        WHERE acp.estado=1
                        AND cp.persona_id= '$personaId'
                    )   
                    GROUP BY rd.id
                ) rf 
                $where 
                ORDER BY rf.fecha_inicio DESC, rf.norden DESC";
                //echo $query;
        return DB::select($query);
    }

    public static function BandejaTramitesf( $input)
    {
        if ($input) {
            $where=" AND IFNULL(tv.id,'2') IN ('$input')";
        } else {
            $where='';
        }
        $personaId=Auth::user()->id;
        $query="SELECT
                IFNULL(tr.id_union,'') AS id_union,
                IFNULL(rd.id,'') AS ruta_detalle_id,
                IFNULL( CONCAT(t.apocope,': ',rd.dtiempo),'') AS tiempo,
                IFNULL(rd.fecha_inicio,'') AS fecha_inicio,
                IFNULL(rd.norden,'') AS norden,
                IFNULL(tr.fecha_tramite,'') AS fecha_tramite,
                IFNULL(f.nombre,'') AS nombre,
                IFNULL(rsp.nombre,'') AS respuesta,
                IFNULL(rspd.nombre,'') AS respuestad,
                IFNULL(rd.observacion,'') AS observacion,
                IFNULL(ts.nombre,'') AS tipo_solicitante,
                IFNULL(
                    IF(tr.tipo_persona='1',
                       CONCAT(tr.paterno,' ',tr.materno,' ',tr.nombre),
                      tr.razon_social),''
                ) AS solicitante,
                IFNULL(rd.alerta_tipo,'') AS alerta_tipo,
                IFNULL(rd.alerta,'') AS alerta,
                IFNULL(rd.condicion,'') AS condicion,
                IFNULL(rd.estado_ruta,'') AS estado_ruta,
                IFNULL(tv.id,'2') AS id,
                IFNULL(tv.nombre,'') AS tipo_estado_visual,
                IFNULL(tv.estado,'') AS estado_visual,
                IFNULL(
                    CONCAT(p.paterno,' ',p.materno, ' ',p.nombre),
                    ''
                ) AS persona_visual,
                IFNULL(p.email,'') AS email,
                IFNULL(tr.ruc,'') AS ruc,
                IFNULL(tr.sumilla,'') AS sumilla

                FROM rutas_detalle rd
                JOIN rutas r ON rd.ruta_id=r.id and r.estado=1
                JOIN tablas_relacion tr ON r.tabla_relacion_id=tr.id 
                JOIN flujos f ON r.flujo_id=f.id
                JOIN tiempos t ON rd.tiempo_id=t.id
                JOIN tipo_solicitante ts ON tr.tipo_persona=ts.id
                LEFT JOIN tipos_respuesta rsp ON rd.tipo_respuesta_id=rsp.id
                LEFT JOIN tipos_respuesta_detalle rspd
                        ON rd.tipo_respuesta_detalle_id=rspd.id
                LEFT JOIN visualizacion_tramite vt ON rd.id=vt.ruta_detalle_id
                        AND vt.usuario_created_at='$personaId'
                LEFT JOIN tipo_visualizacion tv
                        ON vt.tipo_visualizacion_id=tv.id
                LEFT JOIN ( SELECT MAX(vt2.id) AS id
                             FROM visualizacion_tramite vt2
                             JOIN tipo_visualizacion tv2
                             ON vt2.tipo_visualizacion_id=tv2.id
                             AND vt2.estado=1
                             GROUP BY vt2.ruta_detalle_id
                ) vt_s ON vt.id=vt_s.id
                LEFT JOIN personas p ON vt.usuario_created_at=p.id
                WHERE  rd.fecha_inicio IS NOT NULL AND rd.dtiempo_final IS NOT NULL
                AND rd.estado=1
                AND rd.condicion=0
                AND rd.area_id IN (
                    SELECT a.id
                    FROM area_cargo_persona acp
                    INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                    INNER JOIN cargo_persona cp
                            ON cp.id=acp.cargo_persona_id AND cp.estado=1
                    WHERE acp.estado=1
                    AND cp.persona_id= '$personaId'
                )   $where
                GROUP BY rd.id
                ORDER BY rd.fecha_inicio DESC, rd.norden DESC";
        return DB::select($query);
    }

    public static function BandejaTramitesot()
    {
        /*if( Input::has('filtro') ){
            $input= implode( ",",Input::get('filtro') );
            $where=" AND IFNULL(tv.id,'2') IN (".$input.") ";
        }*/
        
        $where= "   AND tr.id_union='".Input::get('tramite')."'
                    AND f.tipo_flujo=2 ";

        $personaId=Auth::user()->id;
        $query="SELECT
                IFNULL(tr.id_union,'') AS id_union,
                IFNULL(rd.id,'') AS ruta_detalle_id,
                IFNULL( CONCAT(t.apocope,': ',rd.dtiempo),'') AS tiempo,
                IFNULL(rd.fecha_inicio,'') AS fecha_inicio,
                IFNULL(rd.norden,'') AS norden,
                IFNULL(tr.fecha_tramite,'') AS fecha_tramite,
                IFNULL(f.nombre,'') AS nombre,
                IFNULL(rsp.nombre,'') AS respuesta,
                IFNULL(rspd.nombre,'') AS respuestad,
                IFNULL(rd.observacion,'') AS observacion,
                IFNULL(ts.nombre,'') AS tipo_solicitante,
                IFNULL(
                    IF(tr.tipo_persona='1',
                       CONCAT(tr.paterno,' ',tr.materno,' ',tr.nombre),
                      tr.razon_social),''
                ) AS solicitante,
                IFNULL(rd.alerta_tipo,'') AS alerta_tipo,
                IFNULL(rd.alerta,'') AS alerta,
                IFNULL(rd.condicion,'') AS condicion,
                IFNULL(rd.estado_ruta,'') AS estado_ruta,
                IFNULL(tv.id,'2') AS id,
                IFNULL(tv.nombre,'') AS tipo_estado_visual,
                IFNULL(tv.estado,'') AS estado_visual,
                IFNULL(
                    CONCAT(p.paterno,' ',p.materno, ' ',p.nombre),
                    ''
                ) AS persona_visual,
                IFNULL(p.email,'') AS email,
                IFNULL(tr.ruc,'') AS ruc,
                IFNULL(tr.sumilla,'') AS sumilla

                FROM rutas_detalle rd
                JOIN rutas r ON rd.ruta_id=r.id and r.estado=1
                JOIN tablas_relacion tr ON r.tabla_relacion_id=tr.id 
                JOIN flujos f ON r.flujo_id=f.id
                LEFT JOIN tiempos t ON rd.tiempo_id=t.id
                LEFT JOIN tipos_respuesta rsp ON rd.tipo_respuesta_id=rsp.id
                LEFT JOIN tipos_respuesta_detalle rspd
                        ON rd.tipo_respuesta_detalle_id=rspd.id
                LEFT JOIN tipo_solicitante ts ON tr.tipo_persona=ts.id
                LEFT JOIN visualizacion_tramite vt ON rd.id=vt.ruta_detalle_id
                        AND vt.usuario_created_at='$personaId'
                LEFT JOIN tipo_visualizacion tv
                        ON vt.tipo_visualizacion_id=tv.id
                LEFT JOIN ( SELECT MAX(vt2.id) AS id
                             FROM visualizacion_tramite vt2
                             JOIN tipo_visualizacion tv2
                             ON vt2.tipo_visualizacion_id=tv2.id
                             AND vt2.estado=1
                             GROUP BY vt2.ruta_detalle_id
                ) vt_s ON vt.id=vt_s.id
                LEFT JOIN personas p ON vt.usuario_created_at=p.id
                WHERE  rd.fecha_inicio IS NOT NULL AND rd.dtiempo_final IS NULL
                AND rd.estado=1
                AND rd.condicion=0
                AND rd.area_id IN (
                    SELECT a.id
                    FROM area_cargo_persona acp
                    INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                    INNER JOIN cargo_persona cp
                            ON cp.id=acp.cargo_persona_id AND cp.estado=1
                    WHERE acp.estado=1
                    AND cp.persona_id= '$personaId'
                )   $where
                GROUP BY rd.id
                ORDER BY rd.fecha_inicio DESC, rd.norden DESC";
        return DB::select($query);
    }
}
