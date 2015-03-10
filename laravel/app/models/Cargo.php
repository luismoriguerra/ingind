<?php

class Cargo extends \Eloquent
{
    public $table = "cargos";

    /**
     * Areas relationship
     */
    public function areas()
    {
        return $this->belongsToMany('Area');
    }
    /**
     * Opciones relationship
     */
    public function opciones()
    {
        return $this->belongsToMany('Opcion');
    }
}
