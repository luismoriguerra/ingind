<?php

class Requisito extends Base
{
    public $table = "requisitos";
    public static $where =['id', 'clasificador_tramite_id', 'nombre', 'cantidad', 'estado'];
    public static $selec =['id', 'clasificador_tramite_id', 'nombre', 'cantidad', 'estado'];
    
    public static function getCargar($array )
    {
        $sSql=" SELECT r.id, r.clasificador_tramite_id,r.nombre,r.cantidad,r.estado
                FROM requisitos r
                WHERE 1=1  ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData;
    }
    
    public static function getRequisito(){
        $r=DB::table('requisitos')
                ->select('id','nombre','estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                    }
                )
                ->orderBy('nombre')
                ->get();
                
        return $r;
    }
}
