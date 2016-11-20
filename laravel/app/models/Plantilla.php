<?php
/**
*
*/
class Plantilla extends Base
{

    public $table = "plantillas";
    public static $where =['id', 'nombre', 'cuerpo', 'path', 'titulo', 'cabecera', 'estado'];
    public static $selec =['id', 'nombre', 'cuerpo', 'path', 'titulo', 'cabecera', 'estado'];

    public static function getPlantillas(){
        return DB::table('plantillas')
                ->select('id', 'nombre', 'cuerpo', 'path', 'titulo', 'cabecera')
                ->where('estado', 1)
                ->orderBy('nombre')
                ->get();
    }

}