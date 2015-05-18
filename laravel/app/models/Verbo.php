<?php

class Verbo extends Base
{
    public $table = "verbos";
    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];
}
