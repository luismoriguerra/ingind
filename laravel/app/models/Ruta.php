<?php

class Ruta extends \Eloquent
{
    protected $_table = "rutas";

    /**
     * Areas relationship
     */
    public function areas()
    {
        return $this->belongsTo('Area');
    }

    private function getRutas(){
        $rutas="";
    }

}
