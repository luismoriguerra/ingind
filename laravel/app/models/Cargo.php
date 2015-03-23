<?php

class Cargo extends Base
{
    public $table = "cargos";
    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];
    /**
     * Areas relationship
     */
    public function personas()
    {
        return $this->belongsToMany('Persona');
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
        //subconsulta
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
        ->whereRaw("co.cargo_id=$cargoId AND co.estado=1 AND m.estado=1")

        ->groupBy('m.id');
        //consulta
        $opciones = DB::table(DB::raw("(".$sql->toSql().") as o"))
                ->select(
                    DB::raw("GROUP_CONCAT( info SEPARATOR '|'  ) as DATA ")
                )
               ->get();

        return $opciones;

    }
}
