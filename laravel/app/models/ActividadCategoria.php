<?php

class ActividadCategoria extends Base
{
    public $table = "actividad_categorias";
    public static $where = ['id', 'categoria', 'estado'];
    public static $selec = ['id', 'categoria', 'estado'];

     public function getListar(){
        $actividad_categoria=DB::table('actividad_categorias')
                ->select('id','categoria','estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                    }
                )
                ->orderBy('categoria')
                ->get();
                
        return $actividad_categoria;
    }

}
