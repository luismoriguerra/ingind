<?php

class BienCaracteristica extends \Eloquent {
	protected $fillable = [];
	public $table = "bien_caracteristica";

	public static function getCaracteristicabyBien()
    {
        $sSql=" SELECT bc.id,bc.descripcion,bc.observacion,bc.valor,bc.alerta,bc.alerta_razon,bc.estado  
                FROM bien_caracteristica bc WHERE bc.estado=1 AND bc.bien_id=".Input::get('idbien');
        $oData = DB::select($sSql);
        return $oData;
    }
}