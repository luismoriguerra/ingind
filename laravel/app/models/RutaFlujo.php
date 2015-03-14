<?php

class RutaFlujo extends \Eloquent
{
    protected $_table = "rutas_flujo";

    /**
     * Areas relationship
     */
    public function areas()
    {
        return $this->belongsTo('Area');
    }

    public function getRutasFlujo(){
        $rutasFlujo =    DB::table('rutas_flujo AS rf')
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
                            ->select('f.nombre AS flujo',
                                    DB::raw(
                                        'CONCAT(
                                            p.paterno," ",p.materno," ",p.nombre
                                        ) AS persona'
                                    ),
                                    'a.nombre AS area',
                                    'rf.n_flujo_ok AS ok',
                                    'rf.n_flujo_error AS error',
                                    'rf.ruta_id_dep AS dep',
                                    DB::raw(
                                        'DATE(rf.created_at) AS fruta'
                                    )
                            )
                            ->get();
        return $rutasFlujo;
    }

}

