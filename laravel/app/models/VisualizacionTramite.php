<?php
class VisualizacionTramite extends Eloquent
{
    public $table="visualizacion_tramite";
    public static function BandejaTramites()
    {
        $personaId=Auth::user()->id;
        $query="SELECT rd.id,
                IFNULL(f.nombre,'') AS nombre,
                IFNULL(t.apocope,'') AS apocope,
                IFNULL(rd.dtiempo,'') AS dtiempo,
                IFNULL(rsp.nombre,'') AS respuesta,
                IFNULL(rspd.nombre,'') AS respuestad,
                IFNULL(rd.observacion,'') AS observacion,
                IFNULL(rd.fecha_inicio,'') AS fecha_inicio,
                IFNULL(rd.norden,'') AS norden,
                IFNULL(rd.alerta_tipo,'') AS alerta_tipo ,
                IFNULL(rd.alerta,'') AS alerta ,
                IFNULL(rd.condicion,'') AS condicion,
                IFNULL(rd.estado_ruta,'') AS estado_ruta,
                IFNULL(tr.id_union,'') AS id_union ,
                IFNULL(tr.fecha_tramite,'') AS fecha_tramite,
                IFNULL(ts.nombre,'') AS tipo_solicitante, 
                IFNULL(tr.razon_social,'') AS razon_social,
                IFNULL(tr.ruc,'') AS ruc,
                CONCAT(tr.paterno, ' ',tr.materno,' ',tr.nombre) AS persona,
                IFNULL(tr.sumilla,'') AS  sumilla,
                IFNULL(tv.id,'') AS  id_visual,
                IFNULL(tv.nombre,'') AS estado_visual,
                CONCAT(p.paterno,' ',p.materno, ' ',p.nombre) AS persona_visual,
                IFNULL(p.email,'') AS email

                FROM rutas_detalle rd 
                JOIN rutas r ON rd.ruta_id=r.id
                JOIN tablas_relacion tr ON r.tabla_relacion_id=tr.id
                JOIN flujos f ON r.flujo_id=f.id
                LEFT JOIN tiempos t ON rd.tiempo_id=t.id
                LEFT JOIN tipos_respuesta rsp ON rd.tipo_respuesta_id=rsp.id
                LEFT JOIN tipos_respuesta_detalle rspd 
                        ON rd.tipo_respuesta_detalle_id=rspd.id
                LEFT JOIN tipo_solicitante ts ON tr.tipo_persona=ts.id
                LEFT JOIN visualizacion_tramite vt ON rd.id=vt.ruta_detalle_id
                LEFT JOIN tipo_visualizacion tv 
                        ON vt.tipo_visualizacion_id=tv.id
                LEFT JOIN personas p ON vt.usuario_created_at=p.id
                WHERE  rd.fecha_inicio IS NOT NULL AND rd.dtiempo_final IS NULL
                AND rd.estado=1
                AND rd.area_id IN (
                    SELECT a.id
                    FROM area_cargo_persona acp
                    INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                    INNER JOIN cargo_persona cp 
                            ON cp.id=acp.cargo_persona_id AND cp.estado=1
                    WHERE acp.estado=1
                    AND cp.persona_id=?
                )
                ORDER BY rd.fecha_inicio DESC, rd.norden DESC";
        $result = DB::select($query,array($personaId));
        return $result;
    }
}