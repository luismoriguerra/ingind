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
}
