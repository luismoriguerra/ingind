<?php

class TipoRespuestaDetalle extends Base
{
    public $table = "tipos_respuesta_detalle";
    public static $where =['id', 'nombre', 'tipo_respuesta_id', 'estado'];
    public static $selec =['id', 'nombre', 'tipo_respuesta_id', 'estado'];
    /**
     * TipoRespuesta relationship
     */
    public function tiporespuesta()
    {
        return $this->belongsTo('TipoRespuesta');
    }
    public static function getTipoRespuesta()
    {
        $query = DB::table('tipos_respuesta_detalle as trd')
                ->join(
                    'tipos_respuesta as tr',
                    'trd.tipo_respuesta_id', '=', 'tr.id'
                )
                ->join(
                    'flujo_tipo_respuesta as ftr',
                    'ftr.tipo_respuesta_id', '=', 'tr.id'
                )
                ->select(
                    'trd.id',
                    'trd.nombre',
                    'trd.estado',
                    'tr.nombre as tiporespuesta',
                    'tr.id as tiporespuesta_id',
                    DB::raw(
                        'CONCAT("TR",tr.id) AS relation'
                    )
                )
                ->where(
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('tr.estado', '=', Input::get('estado') )
                                ->where('trd.estado', '=', Input::get('estado') )
                                ->where('ftr.estado', '=', Input::get('estado') );
                        }

                        if( Input::get('flujo_id') ){
                            $query->where('ftr.flujo_id', '=', Input::get('flujo_id') );
                        }
                    }
                )
                ->groupBy('trd.id')
                ->orderBy('trd.nombre')
                ->get();

        return $query;
    }
}
