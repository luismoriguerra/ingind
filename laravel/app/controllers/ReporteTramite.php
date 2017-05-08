<?php

class ReporteTramite extends Eloquent 
{
    public static function TramiteUnico( $array )
    {
        $sql =" SELECT tr.id_union AS tramite,IF(re.referido=tr.id_union,'',re.referido) detalle,
                re.norden, r.id, r.ruta_flujo_id, tr.sumilla as sumilla,
                IF( MIN( IF( rd.dtiempo_final IS NULL AND rd.fecha_inicio IS NOT NULL, 0, 1) ) = 0
                                AND MAX( rd.alerta_tipo ) < 2, 'Inconcluso',
                                IF( (MIN( IF( rd.dtiempo_final IS NOT NULL AND rd.fecha_inicio IS NOT NULL, 0, 1) ) = 0
                                                OR MIN( IF( rd.dtiempo_final IS NULL AND rd.fecha_inicio IS NULL, 0, 1) ) = 0)
                                                AND MAX( rd.alerta_tipo ) > 1, 'Trunco', 'Concluido'
                                )
                ) estado,
                f.nombre proceso,
                IFNULL(r.fecha_inicio,'') AS fecha_inicio
                FROM referidos re 
                INNER JOIN rutas r ON r.id=re.ruta_id AND r.estado=1
                INNER JOIN tablas_relacion tr ON tr.id=r.tabla_relacion_id AND tr.estado=1
                INNER JOIN rutas_detalle rd ON rd.ruta_id=r.id AND rd.estado=1
                INNER JOIN flujos f ON f.id=r.flujo_id
                WHERE re.estado=1".
                $array['where'].
                "GROUP BY r.id";

        $r= DB::select($sql);
        return $r;
    }

    public static function TramiteDetalle( $array ){
        $sql="  SELECT rd.id, rd.ruta_id, IFNULL(a.nombre,'') as area, rd.condicion,
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
                $array['where']."
                GROUP BY rd.id";

        $set=DB::select('SET group_concat_max_len := @@max_allowed_packet');
        $r= DB::select($sql);
        return $r;
    }
}
