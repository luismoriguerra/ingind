<?php

class Tramite extends Eloquent {
	protected $fillable = [];

	public static function getAllTramites(){
		$sql ="select t.id codigo,ct.nombre_clasificador_tramite tramite,t.fecha_tramite fecha_ingreso,CONCAT_WS(' ',p.nombre,p.paterno,p.materno) persona,t.estado estado,t.observacion observacion,a.nombre area from tramites t 
			inner join personas p on t.persona_id=p.id 
			inner join clasificador_tramite ct on t.clasificador_tramite_id=ct.id 
			inner join areas a on t.area_id=a.id  
			where t.estado=1";

		if(Input::get('buscar')){
			$sql.=" and t.id='".input::get('buscar')."' or ct.nombre_clasificador_tramite='".input::get('buscar')."'";
		}

		$r= DB::select($sql);
        return $r; 
	}
}