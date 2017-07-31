<?php

class TipoRespuesta extends Base
{
    public $table = "tipos_respuesta";
    public static $where =['id', 'nombre', 'tiempo', 'estado'];
    public static $selec =['id', 'nombre', 'tiempo', 'estado'];
    /**
     * TipoRespuestaDetalle relationship
     */
    public function detalles()
    {
        return $this->hasMany('TipoRespuestaDetalle');
    }

    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(tr.id) cant
                FROM tipos_respuesta tr
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql="SELECT tr.id ,tr.nombre,tr.tiempo tiempo_id,              
                tr.estado,
                CASE tr.tiempo
                WHEN '0' THEN 'No'
                WHEN '1' THEN 'Si'
                END tiempo
                FROM tipos_respuesta tr
                WHERE 1=1";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }
    
    public function getTipoRespuesta(){
        $r = DB::table('flujo_tipo_respuesta AS ftr')
                ->join(
                    'tipos_respuesta AS tr',
                    'tr.id', '=', 'ftr.tipo_respuesta_id'
                )
                ->leftJoin(
                    'tiempos AS t',
                    't.id', '=', 'ftr.tiempo_id'
                )
                ->select(
                    'tr.id','tr.nombre',
                    DB::raw(
                        'CONCAT( IFNULL(t.totalminutos,0)*ftr.dtiempo,
                                 "_",
                                 tr.tiempo,
                                 "_",
                                 DATE_ADD(
                                    "'.Input::get('fecha_inicio').'", 
                                    INTERVAL (ftr.dtiempo*IFNULL(t.totalminutos,0)) MINUTE
                                )
                        ) AS evento'
                    )
                )
                ->where(
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('tr.estado', '=', Input::get('estado') )
//                                ->where('ftr.estado', '=', Input::get('estado') )
                                ;
                        }

                        if ( Input::get('flujo_id') ) {
                            $query->where( 'ftr.flujo_id', '=', Input::get('flujo_id'));
                        }
                    }
                )
                ->orderBy('tr.nombre')
                ->get();
        return $r;
    }
}
