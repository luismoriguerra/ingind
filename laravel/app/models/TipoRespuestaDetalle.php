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
}
