<?php

class FlujoInterno extends Base 
{
    public $table = "flujos_internos";
    public static $where =['id', 'nombre_interno', 'nombre', 'flujo_id',  'estado'];
    public static $selec =['id', 'nombre_interno', 'nombre', 'flujo_id',  'estado'];

    public static function getCargarCount( $array )
    {
        $sSql=" SELECT COUNT(fi.id) cant
                FROM flujos_internos fi
                LEFT JOIN flujos f ON f.id=fi.flujo_id
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {


        $sSql=" SELECT fi.id,fi.flujo_id, fi.estado, fi.nombre, fi.nombre_interno, f.nombre flujo, f.id flujo_id
                from flujos_internos fi
                LEFT JOIN flujos f ON fi.flujo_id=f.id
                WHERE 1=1";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

}
