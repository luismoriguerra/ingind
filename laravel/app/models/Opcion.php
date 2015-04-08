<?php

class Opcion extends Base
{
    public $table = "opciones";
    public static $where =['id', 'nombre', 'ruta', 'menu_id', 'estado'];
    public static $selec =['id', 'nombre', 'ruta', 'menu_id', 'estado'];
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
    public static function getOpciones()
    {
        return DB::table('opciones as o')
                    ->join('menus as m', 'o.menu_id', '=', 'm.id')
                    ->select(
                        'o.id',
                        'o.nombre',
                        'o.ruta',
                        'o.estado',
                        'm.nombre as menu',
                        'o.menu_id'
                    )
                    ->get();
    }
}
