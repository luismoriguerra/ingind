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
                ->select(
                    'trd.id',
                    'trd.nombre',
                    'trd.estado',
                    'tr.nombre as tiporespuesta',
                    'tr.id as tiporespuesta_id'
                )
                ->where('tr.estado', '=', 1)
                ->get();

        return $query;
    }
}