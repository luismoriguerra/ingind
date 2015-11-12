<?php

class Carta extends Base
{
    public $table = "cartas";

    public static function Cargar (){
        $r=DB::table('cartas')
                ->select('nro_carta','objetivo','entregable')
                ->where( 
                    function($query){
                        /*if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }*/
                    }
                )
                ->orderBy('nro_carta')
                ->get();
                
        return $r;
    }
}
