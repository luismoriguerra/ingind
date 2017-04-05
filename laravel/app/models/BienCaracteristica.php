<?php

class BienCaracteristica extends \Eloquent {
	protected $fillable = [];
	public $table = "bien_caracteristica";

	public static function getCaracteristicabyBien()
    {
        $sSql=" SELECT bc.id,bc.descripcion,bc.observacion,bc.valor,bc.alerta,bc.alerta_razon,bc.alerta_fecha,bc.estado  
                FROM bien_caracteristica bc WHERE bc.bien_id=".Input::get('idbien');
        $oData = DB::select($sSql);
        return $oData;
    }
}