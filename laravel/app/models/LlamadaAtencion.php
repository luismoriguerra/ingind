<?php

class LlamadaAtencion extends Base
{
    public $table = "nro_max_alerta";
    public static $where =['id', 'nro_max', 'estado'];
    public static $selec =['id', 'nro_max', 'estado'];

}
