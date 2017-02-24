<?php

class MetaFechaVencimiento extends Base
{
    public $table = "metas_fechavencimiento";
    public static $where =['id' , 'meta_cuadro_id' , 'tipo' , 'fecha' , 'comentario', 'estado'];
    public static $selec =['id' , 'meta_cuadro_id' , 'tipo' , 'fecha' , 'comentario', 'estado'];
    
    public static function getCargar($array )
    {
        $sSql=" SELECT mf.id, mf.meta_cuadro_id, mf.tipo, mf.fecha , mf.comentario, mf.estado
                FROM metas_fechavencimiento mf
                WHERE 1=1  ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData;
    }


    public function getMeta(){
        $metacuadro=DB::table('metas')
                ->select('id','nombre','estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                    }
                )
                ->orderBy('id')
                ->get();
                
        return $metacuadro;
    }
    
        public function getMetaCuadro( )
    {
        $sSql=" SELECT mc.id, mc.actividad, mc.estado,m.nombre as meta
                FROM metas_cuadro mc
                INNER JOIN metas m on mc.meta_id=m.id
                WHERE 1=1 ";
        $oData = DB::select($sSql);
        return $oData;
    }
}
