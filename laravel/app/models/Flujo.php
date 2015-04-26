<?php
class Flujo extends Base
{
    public $table = "flujos";
    public static $where =['id', 'nombre', 'estado', 'usuario_created_at'];
    public static $selec =['id', 'nombre', 'estado'];

    public function getFlujo(){
        $flujo=DB::table('flujos')
                ->select('id','nombre','estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }

                        if ( Input::get('usuario') ) {
                            $query->where('usuario_created_at', '=', Auth::user()->id);
                        }
                    }
                )
                ->get();
                
        return $flujo;
    }
}
