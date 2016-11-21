<?php

class Tipotramite extends Eloquent {
	protected $fillable = [];

	public function getAllTiposTramites(){
        $anexos=DB::table('tipo_tramite')
                ->select('id','nombre_tipo_tramite as nombre','estado')
                ->where( 
                    function($query){
                        $query->where('estado','=','1');
                    }
                )
                ->get();  
        return $anexos;
    }
}