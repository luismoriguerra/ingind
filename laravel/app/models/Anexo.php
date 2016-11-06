<?php

class Anexo extends Base {
	protected $fillable = [];

	public static function getAnexosbyTramite(){
        $anexos=DB::table('tramites_anexo')
                ->select()
                ->where( 
                    function($query){
                        if ( Input::get('idtramite') ) {
                            $query->where('tramite_id','=',Input::get('idtramite'));
                        }
                    }
                )
                ->get();  
        return $anexos;
    }
}