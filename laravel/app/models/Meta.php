<?php

class Meta extends Base
{
    public $table = "metas";
    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];

    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(m.id) cant
                FROM metas m
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT m.id, m.nombre, m.estado
                FROM metas m
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }
    public function getMeta(){
        $r=DB::table('metas')
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
                
        return $r;
    }
}
