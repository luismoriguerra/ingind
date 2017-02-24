<?php

class Local extends \Eloquent {
	protected $fillable = [];

	public function getLocal(){
        $area=DB::table('inventario_local')
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
                
        return $area;
    }
}