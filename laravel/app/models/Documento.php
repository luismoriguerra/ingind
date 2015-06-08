<?php

class Documento extends Base
{
    public $table = "documentos";
    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];

    public function getDocumento(){
        $r=DB::table('documentos')
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
