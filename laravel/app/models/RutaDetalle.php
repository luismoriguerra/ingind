<?php
class RutaDetalle extends Eloquent
{
    public $table="rutas_detalle";

    public function getRutadetalle()
    {
        $area_id="";
        $flujo_id="";
        $ruta_detalle_id="";
        $adicional="";

        if ( Input::get('area_id') ) {
            $area_id= Input::get('area_id');
            $flujo_id= Input::get('flujo_id');

            $adicional=
            'WHERE rd.area_id= "'.$area_id.'" 
            AND r.flujo_id= "'.$flujo_id.'"
            GROUP BY rd.id
            HAVING ( MIN(rdv.finalizo)=0 OR IFNULL(rd.dtiempo_final,"")="" )
            ORDER BY fi,rd.created_at';
        }

        if ( Input::get('ruta_detalle_id') ) {
            $ruta_detalle_id= Input::get('ruta_detalle_id');
            $adicional='WHERE rd.id="'.$ruta_detalle_id.'"';
        }

        $query =
            'SELECT rd.id, rd.dtiempo_final, r.flujo_id,
            CONCAT(t.nombre," : ",rd.dtiempo) tiempo,
            rd.observacion,
            a.nombre AS area,f.nombre AS flujo,
            s.nombre AS software,tr.id_union AS id_doc,
            rd.norden, IFNULL(rd.fecha_inicio,"") AS fecha_inicio,
            IFNULL(GROUP_CONCAT(
                CONCAT(
                    rdv.id,
                     "=>",
                    rdv.nombre,
                     "=>",
                    IF(rdv.finalizo=0,"Pendiente","Finalizó")
                )
            SEPARATOR "|"),"") AS verbo,IFNULL(rd.fecha_inicio,"9999") fi,
            DATE_ADD(
                rd.fecha_inicio, 
                INTERVAL (rd.dtiempo*t.totalminutos) MINUTE
            ) AS fecha_max, now() AS hoy
            FROM rutas_detalle rd
            INNER JOIN rutas r ON r.id=rd.ruta_id
            LEFT JOIN rutas_detalle_verbo rdv ON (rd.id=rdv.ruta_detalle_id AND rdv.estado=1)
            INNER JOIN areas a ON a.id=rd.area_id
            INNER JOIN flujos f ON f.id=r.flujo_id
            INNER JOIN tablas_relacion tr ON tr.id=r.tabla_relacion_id
            INNER JOIN softwares s ON s.id=tr.software_id
            INNER JOIN tiempos t ON t.id=rd.tiempo_id '.$adicional;
        $rd = DB::select($query);

        if ( Input::get('ruta_detalle_id') ) {
            return $rd[0];
        }
        else{
            return $rd;
        }
    }
}
?>
