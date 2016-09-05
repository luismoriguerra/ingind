<?php

class Software extends Base
{
    public $table = "softwares";
    public static $where =['id', 'nombre', 'tabla', 'campo', 'estado'];
    public static $selec =['id', 'nombre', 'tabla', 'campo', 'estado'];

    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(s.id) cant
                FROM softwares s
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT s.id, s.nombre,s.tabla,s.campo, s.estado
                FROM softwares s
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }
}
