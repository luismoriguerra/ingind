<?php

class Area extends Base
{
    public $table = "areas";
    public static $where =['id', 'nombre', 'estado'];
    public static $selec =['id', 'nombre', 'estado'];
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
                ->select('id','nombre','estado')
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
