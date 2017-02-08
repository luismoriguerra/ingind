<?php

class TipoSolicitante extends Base
{
    public $table = "tipo_solicitante";
    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];

    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(ts.id) cant
                FROM tipo_solicitante ts
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT ts.id, ts.nombre, ts.estado
                FROM tipo_solicitante ts
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }
    
    public static function getTipoSolicitante(){
        $r=DB::table('tipo_solicitante')
        ->select('id','nombre','estado','pide_empresa')
        ->where( 
            function($query){
                if ( Input::get('estado') ) {
                    $query->where('estado','=','1');
                }

                if ( Input::get('id') ) {
                    $query->where('id','=', Input::get('id') );
                }
                if ( Input::get('pretramite') ) {
                    $query->where('id','!=', '3');
                    $query->where('id','!=', '6' );
                }

                if ( Input::get('validado') ) {
                    $query->where('validado','=', '1');
                }
            }
            )
        ->orderBy('nombre')
        ->get();
        
        return $r;
    }
}
