<?php
class Flujo extends \Eloquent
{
    public $table = "flujos";

    public function getFlujo(){
        $flujo=DB::table('flujos')
                ->select('id','nombre','estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                    }
                )
                ->get();
                
        return $flujo;
    }
}
