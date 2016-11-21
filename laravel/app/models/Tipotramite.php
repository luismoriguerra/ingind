<?php

class TipoTramite extends Base
{
    public $table = "tipo_tramite";
    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];
    
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(tt.id) cant
                FROM tipo_tramite tt
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }
    public static function getCargar( $array )
    {
        $sSql=" SELECT tt.id, tt.nombre, tt.estado
                FROM tipo_tramite tt
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }
    public function getTipoTramite(){
        $tipotramite=DB::table('tipo_tramite')
                ->select('id','nombre_tipo_tramite as nombre','estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                    }
                )
                ->orderBy('nombre')
                ->get();
                
        return $tipotramite;
    }
}
