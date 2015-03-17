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
    public function getOpciones($cargoId)
    {

        $sql = DB::table('cargo_opcion as co')
        ->join(
            'opciones as o', 
            'co.opcion_id', '=', 'o.id'
        )
        ->join(
            'menus as m', 
            'o.menu_id', '=', 'm.id'
        )
        ->select(
            DB::raw(
                "
            CONCAT(m.id, '-',
            GROUP_CONCAT(o.id)) as info"
            )
        )
        ->whereRaw("co.cargo_id=$cargoId AND co.estado=1")

        ->groupBy('m.id');

        $opciones = DB::table(DB::raw("(".$sql->toSql().") as o"))
                ->select(
                    DB::raw("GROUP_CONCAT( info SEPARATOR '|'  ) as DATA ")
                )
               ->get();

        return $opciones;

    }
}
