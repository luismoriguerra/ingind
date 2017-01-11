<?php

class Contratacion extends Base
{
    public $table = "contratacion";
    public static $where =['id', 'titulo','monto_total','objeto','justificacion','actividades','fecha_conformidad','fecha_inicio','fecha_fin','fecha_aviso','programacion_aviso','nro_doc','area_id', 'estado'];
    public static $selec =['id', 'titulo','monto_total','objeto','justificacion','actividades','fecha_conformidad','fecha_inicio','fecha_fin','fecha_aviso','programacion_aviso','nro_doc','area_id', 'estado'];
    
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(c.id) cant
                FROM contratacion c
                LEFT JOIN areas a ON a.id=c.area_id 
                WHERE c.estado=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT c.id, c.titulo,c.monto_total,c.objeto,c.justificacion,c.actividades,case c.fecha_conformidad  when '0000-00-00' then ''  else c.fecha_conformidad end as fecha_conformidad,c.fecha_inicio,c.fecha_fin,c.fecha_aviso,c.programacion_aviso,c.nro_doc,c.area_id, c.estado, a.nombre as area
                FROM contratacion c
                LEFT JOIN areas a ON a.id=c.area_id 
                WHERE c.estado=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

        public static function getContratacionReport($array,$contratacion)
    {     $query = '';
        if($contratacion==1){
          $query.="SELECT c.titulo,a.nombre as area,c.nro_doc,c.monto_total,c.justificacion,c.objeto,c.actividades,c.fecha_inicio,c.fecha_fin,c.fecha_aviso,c.fecha_conformidad
                    FROM contratacion c
                    INNER JOIN areas a on c.area_id=a.id
                    WHERE c.estado=1 ";
        }
        else {
            $query.="SELECT c.*,a.nombre as area,cr.texto,cr.monto,cr.tipo,cr.fecha_inicio as fid,cr.fecha_fin as ffd,cr.fecha_aviso as fad,cr.fecha_conformidad as fcd
                    FROM contra_reque cr
                    INNER JOIN contratacion c on cr.contratacion_id=c.id
                    INNER JOIN areas a on c.area_id=a.id
                    WHERE cr.estado=1";
        }
        $query.=$array['where'];
        $r= DB::select($query);

        return $r;
    }
}
