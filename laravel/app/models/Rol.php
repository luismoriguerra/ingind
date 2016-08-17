<?php

class Rol extends Base
{
    public $table = "roles";
    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];

    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(r.id) cant
                FROM roles r
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT r.id, r.nombre, r.estado
                FROM roles r
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }
    public function getRol(){
        $r=DB::table('roles')
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
