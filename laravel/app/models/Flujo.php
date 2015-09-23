<?php
class Flujo extends Base
{
    public $table = "flujos";
    public static $where =['id', 'nombre', 'estado', 'usuario_created_at'];
    public static $selec =['id', 'nombre', 'estado'];

    public function getFlujo(){
        $flujo=DB::table('flujos AS f')
                ->join(
                    'areas AS a',
                    'a.id', '=', 'f.area_id'
                )
                ->leftJoin(
                    'rutas_flujo AS rf',
                    'rf.flujo_id', '=', 'f.id'
                )
                ->leftJoin('rutas_flujo_detalle AS rfd', function($join)
                {
                    $join->on('rfd.ruta_flujo_id', '=', 'rf.id')
                         ->where('rfd.norden', '=', 1);
                })
                ->select('f.id','f.nombre','f.estado','a.nombre AS area','f.area_id','f.area_id AS evento',
                    DB::raw('IF(f.tipo_flujo=1,"Trámite","Orden Trabajo") as tipo_flujo,f.tipo_flujo as tipo_flujo_id')
                )
                ->where( 
                    function($query){
                        if ( Input::get('usuario') ) {
                            $query->whereRaw('a.id IN ('.
                                                'SELECT a.id
                                                FROM area_cargo_persona acp
                                                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                WHERE acp.estado=1
                                                AND cp.persona_id='.Auth::user()->id.'
                                             )'
                                            );
                                if( Input::get('usuario')==1 ){
                                    $query->where('f.estado','=','1');
                                }
                        }
                        elseif ( Input::get('soloruta') ) {
                            $query->where('f.estado', '=', '1')
                                ->where('rf.estado', '=', '1')
                                ->whereRaw('rf.id is not null')
                                ->whereRaw('rfd.area_id IN ('.
                                                'SELECT a.id
                                                FROM area_cargo_persona acp
                                                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                WHERE acp.estado=1
                                                AND cp.persona_id='.Auth::user()->id.'
                                             )'
                                            );;
                        }
                        elseif ( Input::get('estado') ) {
                            $query->where('f.estado','=','1');
                        }

                        if( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==2 ){
                            $query->where('f.tipo_flujo','=',2);
                        }
                        elseif( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==1 ){
                            $query->where('f.tipo_flujo','=',1);
                        }
                    }
                )
                ->groupBy('f.id')
                ->orderBy('f.nombre')
                ->get();
                
        return $flujo;
    }
}
