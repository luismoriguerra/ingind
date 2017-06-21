<?php

class Inmueble extends \Eloquent {
	protected $fillable = [];
	public $table = "inventario_inmueble";
        
            public static function getCargar(){
        $sql = "SELECT cod_patrimonial, cod_interno, descripcion
                FROM inventario_inmueble
                WHERE estado=1 AND area_id=".Auth::user()->area_id;
        $r= DB::select($sql);
        return $r;
    }
}