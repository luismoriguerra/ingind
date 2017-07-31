<?php

class Inmueble extends \Eloquent {

    protected $fillable = [];
    public $table = "inventario_inmueble";

    public static function getCargar($area) {
        $sql = "SELECT 1 as norden,a.nombre as area,CONCAT_WS(' ',p.paterno,p.materno,p.nombre) persona,il.nombre as 'local',ii.piso,ii.cod_patrimonial,ii.cod_interno, ii.descripcion,ii.oficina,ii.marca,ii.modelo,
                ii.tipo,ii.color,ii.serie,ii.observacion,
                CASE ii.situacion
                WHEN 1 THEN 'MUY BUENO'
                WHEN 2 THEN 'BUENO'
                WHEN 3 THEN 'REGULAR'
                WHEN 4 THEN 'MALO' ELSE '-' END as situacion
                FROM inventario_inmueble ii
                INNER JOIN areas a ON ii.area_id=a.id
                INNER JOIN inventario_local il ON il.id=ii.inventario_local_id
                INNER JOIN personas p ON p.id=ii.persona_id
                WHERE ii.estado=1";
        if (Input::has('area_id')) {
            $sql .= ' AND ii.area_id IN ("' . $area . '") ';
        } else {
            $sql .= " AND ii.area_id=" . $area;
        }
        $r = DB::select($sql);
        return $r;
    }
    
        public static function getCargarHistorico($array) {
        $sql='';
        $sql.=" SELECT 1 as norden,a.nombre as area,iia.cod_patrimonial,iia.cod_interno,CASE WHEN iia.ultimo=1 THEN 'X' ELSE '' END as ultimo 
                FROM inventario_inmueble ii
                INNER JOIN inventario_inmueble_area iia ON iia.inventario_inmueble_id=ii.id AND iia.estado=1
                INNER JOIN areas a ON a.id=iia.area_id
                WHERE ii.estado=1";
        $sql.= $array['where'];
        $sql.=" ORDER BY ii.cod_patrimonial DESC,ii.fecha_creacion DESC";
        $r =DB::select($sql);
        return $r;
    }

}
