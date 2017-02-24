<?php

class Apertura extends \Eloquent {
	protected $fillable = [];
	public $table = "inventario_apertura";

	public function getAperturas(){
        $apertura=DB::table('inventario_apertura')
                ->select('id','fecha_inicio','fecha_fin','observacion','estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                    }
                )
                ->get();                
        return $apertura;
    }
}