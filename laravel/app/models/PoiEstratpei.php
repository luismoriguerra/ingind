<?php

class PoiEstratpei extends Base
{
    public $table = "poi_estrat_pei";
    public static $where =['id', 'poi_id','descripcion','estado'];
    public static $selec =['id', 'poi_id','descripcion','estado'];
    

    public static function getCargar($array )
    {
        $sSql=" SELECT pep.id, pep.poi_id,pep.estado,pep.descripcion
                FROM poi_estrat_pei pep
                WHERE 1=1  ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData;
    }

}
