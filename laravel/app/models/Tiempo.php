<?php

class Tiempo extends Base
{
    public $table = "tiempos";
    public static $where =['id', 'nombre', 'apocope', 'totalminutos', 'estado'];
    public static $selec =['id', 'nombre', 'apocope', 'totalminutos', 'estado'];
}
