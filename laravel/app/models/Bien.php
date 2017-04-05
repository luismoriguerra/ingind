<?php

class Bien extends \Eloquent {
	protected $fillable = [];
	public $table = "bienes";


    
    public static function getbienes( )
    {
        $sSql = "";
        $sSql.=" SELECT b.id,b.descripcion,b.marca,b.modelo,b.nro_interno,b.serie,b.ubicacion,b.fecha_adquisicion,bc.nombre,b.estado,b.bienes_categoria_id 
                FROM bienes b INNER JOIN bienes_categoria bc ON bc.id=b.bienes_categoria_id AND bc.estado=1";

        if(Input::has('area')){
            $sSql.=" AND b.area_id =".Auth::user()->area_id;
        }
        if(Input::has('id')){
            $sSql.=" AND b.id =".Input::get('id');
        }

        $oData = DB::select($sSql);
        return $oData;
    }
}