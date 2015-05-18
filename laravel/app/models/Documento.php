<?php

class Documento extends Base
{
    public $table = "documentos";
    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];
}
