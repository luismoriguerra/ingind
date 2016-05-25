<?php

class Categoria extends Base
{
    public $table = "categorias";
    public static $where = ['id', 'nombre', 'estado'];
    public static $selec = ['id', 'nombre', 'estado'];

}
