<?php

class Categoria extends Base
{
    public $table = "categorias";
    public static $where = ['id', 'nombre', 'estado'];
    public static $selec = ['id', 'nombre', 'estado'];

    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(c.id) cant
                FROM categorias c
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT c.id, c.nombre, c.estado
                FROM categorias c
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

     public function getListar(){
        $categoria=DB::table('categorias')
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
                
        return $categoria;
    }

}
