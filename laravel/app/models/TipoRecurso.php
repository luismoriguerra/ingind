<?php

class TipoRecurso extends \Base
{
    public $table = "tipo_recurso";

    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];

    public function getTipoRecurso(){
        $r=DB::table('tipo_recurso')
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
