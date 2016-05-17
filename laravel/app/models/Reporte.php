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
                $array['proceso'].
                $array['area']."
                GROUP BY rf.id
                ORDER BY a.nombre";

        $r= DB::select($sql);
        return $r;
    }

    public static function Tramite( $array ){

        $sql =" SELECT tr.id_union AS tramite, r.id, 
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
                IF( MIN( IF( rd.dtiempo_final IS NULL AND rd.fecha_inicio IS NOT NULL, 0, 1) ) = 0
                        AND MAX( rd.alerta_tipo ) < 2, 'Inconcluso',
                        IF( (MIN( IF( rd.dtiempo_final IS NOT NULL AND rd.fecha_inicio IS NOT NULL, 0, 1) ) = 0
                                OR MIN( IF( rd.dtiempo_final IS NULL AND rd.fecha_inicio IS NULL, 0, 1) ) = 0)
                                AND MAX( rd.alerta_tipo ) > 1, 'Trunco', 'Concluido'
                        )
                ) estado,
                GROUP_CONCAT( 
                    IF( rd.dtiempo_final IS NULL,
                        CONCAT( rd.norden,' (',a2.nombre,')' ), NULL
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
                INNER JOIN tipo_solicitante ts ON ts.id=tr.tipo_persona and ts.estado=1
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
                      IF(v.finalizo=0,'<font color=#EC2121>Pendiente</font>',CONCAT('<font color=#22D72F>Finalizó</font>(',p.paterno,' ',p.materno,', ',p.nombre,' ',IFNULL(v.documento,''),'//',IFNULL(v.observacion,''),')' ) )
                  )
                    ORDER BY v.orden ASC
                SEPARATOR '|'),'') AS ordenv
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
}
?>
