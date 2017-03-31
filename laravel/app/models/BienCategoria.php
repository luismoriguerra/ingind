<?php

class BienCategoria extends \Eloquent {
	protected $fillable = [];
	public $table = "bienes_categoria";


    
    public static function getCategoriasBien( )
    {
        $sSql=" SELECT c.id,c.nombre,c.observacion,c.estado 
                FROM bienes_categoria c";
        $oData = DB::select($sSql);
        return $oData;
    }

}