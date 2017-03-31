<?php

class CategoriaEvento extends \Eloquent {
	protected $fillable = [];
	public $table = "bien_evento_categoria";

	public static function getCategoriasEvento()
    {	
    	$sSql = "";
        $sSql.="SELECT ce.id,ce.nombre,ce.observacion,ce.estado FROM bien_evento_categoria ce";
        if(Input::has('estado')){
        	$sSql.=" WHERE ce.estado=".Input::get('estado');
        }
        $oData = DB::select($sSql);
        return $oData;
    }
}