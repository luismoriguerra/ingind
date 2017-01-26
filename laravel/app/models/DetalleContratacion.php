<?php

class DetalleContratacion extends Base
{
    public $table = "contra_reque";
    public static $where =['id', 'contratacion_id','fecha_inicio','fecha_fin','fecha_aviso','monto','fecha_conformidad','tipo','texto','programacion_aviso','nro_doc','estado'];
    public static $selec =['id', 'contratacion_id','fecha_inicio','fecha_fin','fecha_aviso','monto','fecha_conformidad','tipo','texto','programacion_aviso','nro_doc','estado'];
    

    public static function getCargar($array )
    {
        $sSql=" SELECT cr.id, cr.contratacion_id,cr.fecha_inicio,cr.fecha_fin,cr.fecha_aviso,cr.monto, IFNULL(cr.fecha_conformidad,'') as fecha_conformidad,
               CASE cr.tipo
                WHEN 1 THEN 'Bienes'
                WHEN 2 THEN 'Servicios'
                END as tipo_nombre,
							cr.tipo,cr.texto,cr.programacion_aviso,cr.nro_doc,cr.estado
                FROM contra_reque cr
               WHERE cr.estado=1  ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData;
    }

}
