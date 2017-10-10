<?php

class RutaFlujoDetalleMicro extends Base
{
    public $table = "rutas_flujo_detalle_micro";
    public static $where = ['id', 'ruta_flujo_id2', 'ruta_flujo_id','ruta_flujo_detalle_id', 'estado'];
    public static $selec = ['id', 'ruta_flujo_id2', 'ruta_flujo_id','ruta_flujo_detalle_id', 'estado'];

}
