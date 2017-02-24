<?php

class Poi extends Base
{
    public $table = "poi";
    public static $where =['id', 'area_id','objetivo_general','ano','tipo_organo','centro_apoyo','meta_siaf','unidad_medida','cantidad_programada_semestral','cantidad_programada_anual','linea_estrategica_pdlc','estado'];
    public static $selec =['id', 'area_id','objetivo_general','ano','tipo_organo','centro_apoyo','meta_siaf','unidad_medida','cantidad_programada_semestral','cantidad_programada_anual','linea_estrategica_pdlc','estado'];
    
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(p.id) cant
                FROM poi p
                LEFT JOIN areas a ON a.id=p.area_id 
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT p.id, p.area_id, p.objetivo_general, p.ano, p.tipo_organo, p.centro_apoyo, p.meta_siaf, p.unidad_medida, p.cantidad_programada_semestral, p.cantidad_programada_anual, p.linea_estrategica_pdlc, p.estado, a.nombre as area
                FROM poi p
                LEFT JOIN areas a ON a.id=p.area_id 
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

}
