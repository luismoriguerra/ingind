<?php

class CaracteristicaEvento extends \Eloquent {
	protected $fillable = [];
	public $table = "bien_caracteristica_evento";

	public static function getEventosByCaracteristica()
    {
        $sSql=" SELECT bce.id,bce.descripcion,ce.nombre,bce.confirmacion 
        		FROM bien_caracteristica_evento bce  
        		INNER JOIN bien_evento_categoria ce ON bce.evento_categoria_id=ce.id AND ce.estado=1 
        		WHERE bce.estado=1 AND bce.bien_caracteristica_id=".Input::get('idcaracteristica');
        $oData = DB::select($sSql);
        return $oData;
    }
}