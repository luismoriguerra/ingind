<?php

class PoiTipo extends Base
{
    public $table = "poi_tipos";
    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];
    
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(pt.id) cant
                FROM poi_tipos pt
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT pt.id, pt.nombre, pt.estado
                FROM poi_tipos pt
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }


    public function getPoiTipo(){
        $poi_tipo=DB::table('poi_tipos')
                ->select('id','nombre','estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                    }
                )
                ->orderBy('nombre')
                ->get();
                
        return $poi_tipo;
    }
}
