<?php

class TipoRespuesta extends \Eloquent
{
    public $table = "tipos_respuesta";

    /**
     * TipoRespuestaDetalle relationship
     */
    public function detalles()
    {
        return $this->hasMany('TipoRespuestaDetalle');
    }
}
