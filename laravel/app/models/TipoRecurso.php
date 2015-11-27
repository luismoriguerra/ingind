<?php

class TipoRecurso extends \Base
{
    public $table = "tipo_recurso";

    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];
}
