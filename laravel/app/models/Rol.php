<?php

class Rol extends Base
{
    public $table = "roles";
    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];
}
