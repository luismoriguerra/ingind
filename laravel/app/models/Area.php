<?php

class Area extends Base
{
    public $table = "areas";
    public static $where =['id', 'nombre', 'id_int', 'id_ext', 'imagen', 'imagenc', 'estado'];
    public static $selec =['id', 'nombre', 'id_int', 'id_ext', 'imagen', 'imagenc', 'estado'];
    /**
     * Cargos relationship
     */
    /*public function cargos()
    {
        return $this->belongsToMany('Cargo');
    }*/
    /**
     * Rutas relationship
     */
    public function rutas()
    {
        return $this->hasMany('Ruta');
    }

    public function getArea(){
        $area=DB::table('areas')
                ->select('id','nombre','estado','imagen as evento')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                    }
                )
                ->get();
                
        return $area;
    }
}
