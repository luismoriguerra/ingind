<?php

class ActividadCategoria extends Base
{
    public $table = "actividad_categorias";
    public static $where = ['id', 'nombre', 'estado', 'area'];
    public static $selec = ['id', 'nombre', 'estado', 'area'];

    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(v.id) cant
                FROM actividad_categorias v
                INNER JOIN areas vv ON v.area_id = vv.id
                WHERE  vv.id IN(
                SELECT acp.area_id
                                    FROM area_cargo_persona acp
                                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                    WHERE acp.estado=1
                                    AND cp.persona_id=".Auth::user()->id.")";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT v.id, v.area_id, v.ruta_flujo_id, v.nombre, v.estado, vv.nombre as area
                FROM actividad_categorias v
                INNER JOIN areas vv ON v.area_id = vv.id
                WHERE  vv.id IN(
                SELECT acp.area_id
                                    FROM area_cargo_persona acp
                                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                    WHERE acp.estado=1
                                    AND cp.persona_id=".Auth::user()->id.")";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

    public function getListar(){
        $r=DB::table('actividad_categorias')
                ->select('id','nombre','estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                            $query->where('area_id','=',Auth::user()->area_id);
                        }
                    }
                )
                ->orderBy('nombre')
                ->get();
                
        return $r;
    }
    
}
