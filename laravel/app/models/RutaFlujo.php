<?php
class RutaFlujo extends Eloquent
{
    public $table="rutas_flujo";

    /**
     * Areas relationship
     */
    public function areas()
    {
        return $this->belongsTo('Area');
    }

    public function actualizarProduccion()
    {
        $rf = DB::table('rutas_flujo')
              ->where('id', '=', Input::get('ruta_flujo_id'))
              ->update(array("estado"=>1));
        return $rf;
    }
    
    public function getRutaFlujo(){
        $rutaFlujo =    DB::table('rutas_flujo AS rf')
                            ->join(
                                'flujos AS f',
                                'f.id','=','rf.flujo_id'
                            )
                            ->join(
                                'personas AS p',
                                'p.id','=','rf.persona_id'
                            )
                            ->join(
                                'areas AS a',
                                'a.id','=','rf.area_id'
                            )
                            ->select('f.nombre AS flujo','rf.estado AS cestado',
                                    'rf.id',
                                    DB::raw(
                                        'CONCAT(
                                            p.paterno," ",p.materno," ",p.nombre
                                        ) AS persona'
                                    ),
                                    'a.nombre AS area',
                                    'rf.n_flujo_ok AS ok',
                                    'rf.n_flujo_error AS error',
                                    DB::raw(
                                        'IFNULL(rf.ruta_id_dep,"") AS dep'
                                    ),
                                    DB::raw(
                                        'DATE(rf.created_at) AS fruta'
                                    ),
                                    DB::raw(
                                        'IF(rf.estado=1,"Produccion",
                                            IF(rf.estado=2,"Pendiente","Inactivo")
                                        ) AS estado'
                                    )
                            )
                            ->get();
        return $rutaFlujo;
    }

    public function getRutaFlujoProduccion(){
        $rutaFlujo =    DB::table('rutas_flujo AS rf')
                            ->join(
                                'flujos AS f',
                                'f.id','=','rf.flujo_id'
                            )
                            ->join(
                                'personas AS p',
                                'p.id','=','rf.persona_id'
                            )
                            ->join(
                                'areas AS a',
                                'a.id','=','rf.area_id'
                            )
                            ->select('f.nombre AS flujo','rf.estado AS cestado',
                                    'rf.id',
                                    DB::raw(
                                        'CONCAT(
                                            p.paterno," ",p.materno," ",p.nombre
                                        ) AS persona'
                                    ),
                                    'a.nombre AS area',
                                    'rf.n_flujo_ok AS ok',
                                    'rf.n_flujo_error AS error',
                                    DB::raw(
                                        'IFNULL(rf.ruta_id_dep,"") AS dep'
                                    ),
                                    DB::raw(
                                        'DATE(rf.created_at) AS fruta'
                                    ),
                                    DB::raw(
                                        'IF(rf.estado=1,"Produccion",
                                            IF(rf.estado=2,"Pendiente","Inactivo")
                                        ) AS estado'
                                    )
                            )
                            ->get();
        return $rutaFlujo;
    }

    public function getRutaFlujoDetalle(){
        $rutaFlujoD =    DB::table('rutas_flujo AS rf')
                            ->join(
                                'rutas_flujo_detalle AS rfd',
                                'rf.id','=','rfd.ruta_flujo_id'
                            )
                            ->join(
                                'flujos AS f',
                                'f.id','=','rf.flujo_id'
                            )
                            ->join(
                                'personas AS p',
                                'p.id','=','rf.persona_id'
                            )
                            ->join(
                                'areas AS a',
                                'a.id','=','rf.area_id'
                            )
                            ->join(
                                'areas AS a2',
                                'a2.id','=','rfd.area_id'
                            )
                            ->leftJoin(
                                'rutas_flujo_detalle_verbo AS rfdv', 
                                function($join)
                                {
                                    $join->on(
                                        'rfdv.ruta_flujo_detalle_id','=','rfd.id'
                                    )
                                    ->where('rfdv.estado', '=', '1');
                                }
                            )
                            ->select('rf.area_id','a.nombre as area','rfd.id',
                                    'rf.persona_id','f.nombre as flujo',
                                    'rfd.area_id as area_id2','a2.nombre as area2',
                                    'rfd.norden','rf.flujo_id',
                                    DB::raw(
                                        'IFNULL(rfd.tiempo_id,"") AS tiempo_id,
                                        IFNULL(rfd.dtiempo,"") AS dtiempo,
                                        CONCAT(
                                            p.paterno," ",p.materno," ",p.nombre
                                        ) AS persona,
                                        IFNULL(
                                            GROUP_CONCAT(
                                            rfdv.nombre SEPARATOR "|"
                                            ),""
                                        ) as verbo'
                                    )
                            )
                            ->where( 'rf.id','=', Input::get('ruta_flujo_id') )
                            ->where( 'rfd.estado', '=', '1')
                            ->groupBy( 'rfd.id' )
                            ->orderBy( 'rfd.norden', 'asc')
                            ->get();
        return $rutaFlujoD;
    }
}
?>
