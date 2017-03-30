<?php

class MetaArchivo extends Base
{
    public $table = "metas_archivo";
    public static $where =['id' , 'avance_id' , 'ruta' , 'tipo_avance', 'estado'];
    public static $selec =['id' , 'avance_id' , 'ruta' , 'tipo_avance', 'estado'];
    

//
//        public function getFecha1(){
//        $metacuadro=DB::table('metas_fechavencimiento')
//                ->select('id','fecha as nombre','estado')
//                ->where( 
//                    function($query){
//                        if ( Input::get('estado') ) {
//                            $query->where('estado','=','1');
//                            
//                        }
//                        if ( Input::get('meta_cuadro_id') ) {
//                            $meta_cuadro_id = Input::get("meta_cuadro_id");
//                            $query->where('tipo','=','1');
//                            $query->where('meta_cuadro_id','=',$meta_cuadro_id);
//                        }
//                    }
//                )
//                ->orderBy('id')
//                ->get();
//                
//        return $metacuadro;
//    }
//    
//        public function getMetaCuadro( )
//    {
//        $sSql=" SELECT mc.id, mc.actividad, mc.estado,m.nombre as meta
//                FROM metas_cuadro mc
//                INNER JOIN metas m on mc.meta_id=m.id
//                WHERE 1=1 ";
//        $oData = DB::select($sSql);
//        return $oData;
//    }
}
