<?php

class Referido extends Base
{
    public $table = "referidos";

    public function getReferido(){
        DB::beginTransaction();

        DB::commit();

        return  array(
            'rst'=>1,
            'msj'=>'Registro realizado con éxito'
        );
    }
}
