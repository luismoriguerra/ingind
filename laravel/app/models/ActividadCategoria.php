<?php

class ActividadCategoria extends Base
{
    public $table = "actividad_categorias";
    public static $where = ['id', 'nombre', 'estado'];
    public static $selec = ['id', 'nombre', 'estado'];

     public static function getListar(){
        $actividad_categoria=DB::table('actividad_categorias')
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
                
        return $actividad_categoria;
    }
    
}
