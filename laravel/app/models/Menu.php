<?php

class Menu extends Base
{
    public $table = "menus";
    public static $where =['id', 'nombre', 'class_icono', 'estado'];
    public static $selec =['id', 'nombre', 'class_icono', 'estado'];
    /**
     * Opciones relationship
     */
    public function opciones()
    {
        return $this->hasMany('Opcion');
    }

}
