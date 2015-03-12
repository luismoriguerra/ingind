<?php

class Ruta extends \Eloquent
{
    public $table = "rutas";

    /**
     * Areas relationship
     */
    public function areas()
    {
        return $this->belongsTo('Area');
    }

    private function 

}
