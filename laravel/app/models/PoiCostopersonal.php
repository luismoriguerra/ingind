<?php

class PoiCostopersonal extends Base
{
    public $table = "poi_costo_personal";
    public static $where =['id', 'poi_id','rol_id','modalidad','monto','estimacion','essalud','subtotal','estado'];
    public static $selec =['id', 'poi_id','rol_id','modalidad','monto','estimacion','essalud','subtotal','estado'];
    

    public static function getCargar($array )
    {
        $sSql=" SELECT pcp.id, pcp.poi_id, pcp.rol_id, pcp.modalidad, pcp.monto, pcp.estimacion, pcp.essalud, pcp.subtotal, pcp.estado,r.nombre as rol
                FROM poi_costo_personal pcp
                INNER JOIN roles r on r.id=pcp.rol_id
                WHERE 1=1  ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData;
    }

}
