<?php

class TipoActividad extends \Base
{
    public $table = "tipo_actividad";

    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];
}
