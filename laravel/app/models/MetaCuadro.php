<?php

class MetaCuadro extends Base
{
    public $table = "metas_cuadro";
    public static $where =['id' , 'meta_id' , 'anio', 'actividad', 'estado'];
    public static $selec =['id' , 'meta_id' , 'anio', 'actividad', 'estado'];
    
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(mc.id) cant
                FROM metas_cuadro mc
                INNER JOIN metas m on mc.meta_id=m.id
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT mc.id,mc.meta_id, mc.actividad, mc.anio, mc.estado,m.nombre as meta
                FROM metas_cuadro mc
                INNER JOIN metas m on mc.meta_id=m.id
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
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
        
        public function getMetaCuadro($array )
    {
        $sSql=" SELECT m.nombre,mc.actividad,mf1.comentario as d,mf1.fecha as df,mf2.comentario as p,mf2.fecha as pf
                FROM metas_cuadro mc
                INNER JOIN metas m on mc.meta_id=m.id
                LEFT JOIN metas_fechavencimiento mf1 on mc.id=mf1.meta_cuadro_id and mf1.tipo=1
                LEFT JOIN metas_fechavencimiento mf2 on mc.id=mf2.meta_cuadro_id and mf2.relacion_id=mf1.id
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData;
    }
}
