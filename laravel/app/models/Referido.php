<?php

class Referido extends Base
{
    public $table = "referidos";

    public function getReferido(){
        DB::beginTransaction();

        DB::commit();

        return  array(
            'rst'=>1,
            'msj'=>'Registro realizado con éxito'
        );
    }
    
     public static function getListarCount( $array )
    {
        $sSql=" select COUNT(r.id) cant
                from referidos r
                where r.estado=1 AND r.referido!=''";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }
    
    public static function getListar( $array )
    {
        $sSql=" select r.id,r.ruta_id,r.tabla_relacion_id,r.ruta_detalle_id,r.referido,r.fecha_hora_referido
                from referidos r
                where r.estado=1 AND r.referido!=''";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        
        $oData = DB::select($sSql);
        return $oData;
    }
}
