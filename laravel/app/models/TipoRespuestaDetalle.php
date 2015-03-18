<?php

class TipoRespuestaDetalle extends \Eloquent
{
    public $table = "tipos_respuesta_detalle";

    /**
     * TipoRespuesta relationship
     */
    public function tiporespuesta()
    {
        return $this->belongsTo('TipoRespuesta');
    }
}
