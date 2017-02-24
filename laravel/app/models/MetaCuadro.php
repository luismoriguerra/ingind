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
    
        public function getMetaCuadro( )
    {
        $sSql=" SELECT mc.id,m.nombre as meta, mc.actividad, mc.estado,IFNULL(mf.fecha,'') as fa,
                (SELECT GROUP_CONCAT(fecha) 
                FROM metas_fechavencimiento mfa
                WHERE mc.id=mfa.meta_cuadro_id and mf.fecha>mfa.fecha and mfa.tipo=2
                GROUP BY  mfa.meta_cuadro_id ) as fpt
                                FROM metas_cuadro mc
                                INNER JOIN metas m on mc.meta_id=m.id
                LEFT JOIN metas_fechavencimiento mf on mc.id=mf.meta_cuadro_id and tipo=1
                                WHERE 1=1 
                                order by m.nombre,mc.actividad";
        $oData = DB::select($sSql);
        return $oData;
    }
}
