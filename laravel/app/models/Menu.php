<?php

class Menu extends Base
{
    public $table = "menus";
    public static $where =['id', 'nombre', 'ruta', 'class_icono', 'estado'];
    public static $selec =['id', 'nombre', 'ruta', 'class_icono', 'estado'];
    /**
     * Opciones relationship
     */
    public function opciones()
    {
        return $this->hasMany('Opcion');
    }

}
