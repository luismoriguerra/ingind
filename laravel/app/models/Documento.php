<?php

class Documento extends Base
{
    public $table = "documentos";
    public static $where =['id', 'nombre', 'area', 'posicion', 'posicion_fecha', 'estado'];
    public static $select =['id', 'nombre', 'area', 'posicion', 'posicion_fecha', 'estado'];
    
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(doc.id) cant
                FROM documentos doc
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT doc.id, doc.nombre, doc.area, doc.posicion, doc.posicion_fecha, doc.estado,
               (
               CASE doc.area
                    WHEN '0' THEN 'Sin Siglas'
                    ELSE 'Con Siglas'
                END
               )as areas,
                (
                CASE doc.posicion
                    WHEN '0' THEN 'Centro'
                    WHEN '1' THEN 'Izquierda'
                    ELSE 'Derecha'
                END
                ) as posiciones,
                (
                CASE doc.posicion_fecha
                    WHEN '0' THEN 'Sin Fecha'
                    WHEN '1' THEN 'Arriba Izquierda'
                    WHEN '2' THEN 'Arriba Derecha'
                    WHEN '3' THEN 'Abajo Izquierda'
                    ELSE 'Abajo Derecha'
                END
                ) as posiciones_fecha

                FROM documentos doc
                                 
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

    public static function getDocumento(){
        $r=DB::table('documentos')
                ->select('id', DB::raw('CONCAT_WS( " " ,nombre,IF(area=0," Sin Siglas","")) as nombre'),'estado','area','posicion','posicion_fecha')

                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                    }
                )
                ->orderBy('nombre')
                ->get();
                
        return $r;
    }

}
