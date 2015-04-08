<?php
class FlujoTipoRespuesta extends Base
{
    public $table = "flujo_tipo_respuesta";
    public static $where = ['id', 'dtiempo', 'flujo_id', 'tipo_respuesta_id',
     'tiempo_id', 'estado'];
    public static $selec = ['id', 'dtiempo', 'flujo_id', 'tipo_respuesta_id',
     'tiempo_id', 'estado'];
    
    /**
     * Flujo relationship
     */
    public function flujo()
    {
        return $this->belongsTo('Flujo');
    }
}
