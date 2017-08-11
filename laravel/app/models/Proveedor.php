<?php

class Proveedor extends Base
{
    public $table = "contabilidad_proveedores";
    public static $where =['id', 'ruc', 'proveedor', 'estado'];
    public static $selec =['id', 'ruc', 'proveedor', 'estado'];
    
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(v.id) cant
                FROM contabilidad_proveedores v
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT v.id, v.ruc, v.proveedor, v.estado
                FROM contabilidad_proveedores v
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }


    public function getProveedor(){
        $verbo=DB::table('contabilidad_proveedores')
                ->select('id','ruc','proveedor', 'estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                    }
                )
                ->orderBy('proveedor')
                ->get();
                
        return $verbo;
    }
}
