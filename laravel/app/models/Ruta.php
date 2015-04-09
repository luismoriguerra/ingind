<?php
class Ruta extends Eloquent
{
    public $table="rutas";

    /**
     * Areas relationship
     */
    public function crearRuta(){
        DB::beginTransaction();
            

        DB::commit();

        return  array(
                    'rst'=>1,
                    'msj'=>''
                );
    }
}
?>
