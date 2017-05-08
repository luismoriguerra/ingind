<?php

class MetaFechaVencimiento extends Base
{
    public $table = "metas_fechavencimiento";
    public static $where =['id' , 'meta_cuadro_id' , 'tipo' , 'fecha' , 'comentario', 'estado'];
    public static $selec =['id' , 'meta_cuadro_id' , 'tipo' , 'fecha' , 'comentario', 'estado'];
    
    public static function getCargar($array )
    {
        $sSql=" SELECT mf.id, mf.meta_cuadro_id, mf.tipo, mf.fecha ,IFNULL(mf.fecha_add,'') as fecha_add , mf.comentario, mf.estado, mf.relacion_id
                FROM metas_fechavencimiento mf
                WHERE 1=1  ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData;
    }


        public function getFecha1(){
        $metacuadro=DB::table('metas_fechavencimiento')
                ->select('id','estado', DB::raw('CONCAT(fecha, "-", substr(comentario,1,12),".") AS nombre'))
                ->where( 
                    function($query){
                        if ( Input::has('estado') ) {
                            $query->where('estado','=','1');
                            
                        }
                        if ( Input::has('meta_cuadro_id') ) {
                            $meta_cuadro_id = Input::get("meta_cuadro_id");
                            $query->where('tipo','=','1');
                            $query->where('meta_cuadro_id','=',$meta_cuadro_id);
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
