<?php

class PoiActividad extends Base
{
    public $table = "poi_actividades";
    public static $where =['id','poi_id', 'poi_estrat_pei_id','orden','actividad','unidad_medida','indicador_cumplimiento','estado'];
    public static $selec =['id','poi_id', 'poi_estrat_pei_id','orden','actividad','unidad_medida','indicador_cumplimiento','estado'];
    

    public static function getCargar($array )
    {
        $sSql=" SELECT pa.id, pa.poi_id, pa.poi_estrat_pei_id, pa.orden, pa.actividad, pa.unidad_medida, pa.indicador_cumplimiento,  pa.estado, pep.descripcion as estrat_pei
                FROM poi_actividades pa
                INNER JOIN poi_estrat_pei pep on pep.id=pa.poi_estrat_pei_id
                WHERE 1=1  ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData;
    }

}
