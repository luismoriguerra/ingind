<?php

class FechaLaborableArea extends Base
{
    public $table = "fechas_areas_laborables";
    public static $where = ['id', 'fecha_laborable_id', 'area_id', 'estado'];
    public static $selec = ['id', 'fecha_laborable_id', 'area_id', 'estado'];
}
