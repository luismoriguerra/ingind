<?php

class Menu extends \Eloquent
{
    public $table = "menus";

    /**
     * Opciones relationship
     */
    public function opciones()
    {
        return $this->hasMany('Opcion');
    }

}
