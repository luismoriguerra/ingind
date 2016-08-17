<?php
/**
*
*/
class Plantilla extends Base
{

    public $table = "plantillas";
    public static $where =['id', 'nombre', 'cuerpo', 'path', 'titulo', 'cabecera', 'estado'];
    public static $selec =['id', 'nombre', 'cuerpo', 'path', 'titulo', 'cabecera', 'estado'];

}