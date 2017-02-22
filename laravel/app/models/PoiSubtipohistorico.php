<?php

class PoiSubtipohistorico extends Base
{
    public $table = "poi_subtipos_historico";
    public static $where =['id', 'subtipo_id', 'costo', 'fecha_cambio', 'estado'];
    public static $selec =['id', 'subtipo_id', 'costo', 'fecha_cambio', 'estado'];
    
    
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
