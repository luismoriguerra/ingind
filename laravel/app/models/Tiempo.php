<?php

class Tiempo extends Base
{
    public $table = "tiempos";
    public static $where =['id', 'nombre', 'apocope', 'totalminutos', 'estado'];
    public static $selec =['id', 'nombre', 'apocope', 'totalminutos', 'estado'];

        public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(t.id) cant
                FROM tiempos t
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT t.id, t.nombre,t.apocope,t.totalminutos, t.estado
                FROM tiempos t
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

}
