<?php

class TipoRespuesta extends Base
{

    public $table = "tipos_respuesta";
    public static $where =['id', 'nombre', 'tiempo', 'estado'];
    public static $selec =['id', 'nombre', 'tiempo', 'estado'];


    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(tr.id) cant
                FROM tipos_respuesta tr
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql="SELECT tr.id ,tr.nombre,tr.tiempo tiempo_id,              
                tr.estado,
                CASE tr.tiempo
                WHEN '0' THEN 'No'
                WHEN '1' THEN 'Si'
                END tiempo
                FROM tipos_respuesta tr
                WHERE 1=1";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

}
