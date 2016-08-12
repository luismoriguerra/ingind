<?php

class TipoSolicitante extends Base
{
    public $table = "tipo_solicitante";
    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];

    public static function getTipoSolicitante(){
        $r=DB::table('tipo_solicitante')
        ->select('id','nombre','estado')
        ->where( 
            function($query){
                if ( Input::get('estado') ) {
                    $query->where('estado','=','1');
                }

                if ( Input::get('id') ) {
                    $query->where('id','=', Input::get('id') );
                }
            }
            )
        ->orderBy('nombre')
        ->get();
        
        return $r;
    }
}
