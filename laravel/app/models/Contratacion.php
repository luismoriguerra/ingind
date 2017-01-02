<?php

class Contratacion extends Base
{
    public $table = "contratacion";
    public static $where =['id', 'titulo','monto_total','objeto','justificacion','actividades','fecha_conformidad','fecha_inicio','fecha_fin','fecha_aviso','programacion_aviso','nro_doc','area_id', 'estado'];
    public static $selec =['id', 'titulo','monto_total','objeto','justificacion','actividades','fecha_conformidad','fecha_inicio','fecha_fin','fecha_aviso','programacion_aviso','nro_doc','area_id', 'estado'];
    
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(c.id) cant
                FROM contratacion c
                LEFT JOIN areas a ON a.id=c.area_id 
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT c.id, c.titulo,c.monto_total,c.objeto,c.justificacion,c.actividades,case c.fecha_conformidad  when '0000-00-00' then ''  else c.fecha_conformidad end as fecha_conformidad,c.fecha_inicio,c.fecha_fin,c.fecha_aviso,c.programacion_aviso,c.nro_doc,c.area_id, c.estado, a.nombre as area
                FROM contratacion c
                LEFT JOIN areas a ON a.id=c.area_id 
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }


//    public function getContratacion(){
//        $verbo=DB::table('contratacion')
//                ->select('id', 'titulo','monto_total','objeto','justificacion','actividades','fecha_conformidad','fecha_inicio','fecha_fin','fecha_aviso','programacion_aviso','nro_doc','area_id', 'estado')
//                ->where( 
//                    function($query){
//                        if ( Input::get('estado') ) {
//                            $query->where('estado','=','1');
//                        }
//                    }
//                )
//                ->orderBy('titulo')
//                ->get();
//                
//        return $verbo;
//    }
}
