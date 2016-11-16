<?php

class Area extends Base
{
    public $table = "areas";
    public static $where =['id', 'nombre', 'nemonico', 'id_int', 'id_ext', 'imagen', 'imagenc','imagenp', 'estado'];
    public static $selec =['id', 'nombre', 'nemonico', 'id_int', 'id_ext', 'imagen', 'imagenc','imagenp', 'estado'];
    /**
     * Cargos relationship
     */
    /*public function cargos()
    {
        return $this->belongsToMany('Cargo');
    }*/
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(a.id) cant
                FROM areas a
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT a.id, a.nombre,a.nemonico, a.estado
                FROM areas a
                WHERE 1=1 ";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

  



    public function personas() {
        return $this->hasMany('Persona');
    }
    /**
     * Rutas relationship
     */
    public function rutas()
    {
        return $this->hasMany('Ruta');
    }

    public function getArea(){
        $area=DB::table('areas')
                ->select('id','nombre','nemonico','estado','imagen as evento')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                        if ( Input::has('areapersona') ){
                            $query->whereRaw('  FIND_IN_SET( id, 
                                                    (
                                                    SELECT acp.area_id
                                                    FROM area_cargo_persona acp
                                                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                    WHERE acp.estado=1
                                                    AND cp.persona_id='.Auth::user()->id.'
                                                    )       )>0 ');
                        }

                    }
                )
                ->orderBy('nombre')
                ->get();
                
        return $area;
    }

    public function getListar(){
        $area=DB::table('areas')
                ->select('id','nombre','nemonico','estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                        if ( Input::has('areapersona') ){

                            $sql = "SELECT acp.area_id
                                                    FROM area_cargo_persona acp
                                                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                    WHERE acp.estado=1
                                                    AND cp.persona_id=".Auth::user()->id;

                            $areas= DB::select($sql);
                            var_dump($areas);
                            exit();
                    
                            $query->whereRaw('  FIND_IN_SET( id, 
                                                    (
                                                    SELECT acp.area_id
                                                    FROM area_cargo_persona acp
                                                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                    WHERE acp.estado=1
                                                    AND cp.persona_id='.Auth::user()->id.'
                                                    )       )>0 ');
                        }
                    }
                )
                ->orderBy('nombre')
                ->get();
                
        return $area;
    }
}
