<?php

class Opcion extends \Eloquent
{
    public $table = "opciones";

    /**
     * Cargos relationship
     */
    public function cargos()
    {
        return $this->belongsToMany('Cargo');
    }
    /**
     * Menu relationship
     */
    public function menu()
    {
        return $this->belongsTo('Menu');
    }
}
