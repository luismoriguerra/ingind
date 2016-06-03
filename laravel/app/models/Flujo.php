<?php
class Flujo extends Base
{
    public $table = "flujos";
    public static $where =['id', 'nombre', 'estado', 'categoria_id',
                            'usuario_created_at'];
    public static $selec =['id', 'nombre', 'estado','categoria_id'];

    public function getFlujo(){
        if( Input::has('pasouno') ){
            $usuario=Auth::user()->id;
            $where="";
                if( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==2 ){
                    $where=" AND f.tipo_flujo=2";
                }
                elseif( Input::has('tipo_flujo') AND Input::get('tipo_flujo')==1 ){
                    $where=" AND f.tipo_flujo=1";
                }
            $sql="  SELECT f.id, f.nombre, f.estado, a.nombre as area, 
                    f.area_id, f.area_id as evento, 
                    IF(f.tipo_flujo=1,'Trámite','Proceso de oficio') as tipo_flujo,
                    f.tipo_flujo as tipo_flujo_id,
                    GROUP_CONCAT(
                        CONCAT(rf.id,'|',rfd.id,'|',rfd.area_id,'|',rfd.norden)
                    ) validacion
                    FROM flujos as f 
                    INNER JOIN areas as a on a.id = f.area_id 
                    INNER JOIN rutas_flujo as rf on rf.flujo_id = f.id AND rf.estado = 1
                    INNER JOIN rutas_flujo_detalle as rfd on rfd.ruta_flujo_id = rf.id and rfd.norden = 1  AND rfd.estado=1
                    WHERE  f.estado = 1  
                    AND rfd.area_id IN (
                        SELECT a.id
                        FROM area_cargo_persona acp
                        INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                        INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                        WHERE acp.estado=1
                        AND cp.persona_id= $usuario
                    )
                    $where
                    GROUP BY f.id 
                    ORDER BY f.id ASC";
        $flujo=DB::select($sql);
        }
        else{
        $flujo=DB::table('flujos AS f')
                ->join(
                    'areas AS a',
                    'a.id', '=', 'f.area_id'
                )
                ->leftJoin(
                    'categorias AS c',
                    'c.id', '=', 'f.categoria_id'
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
                    DB::raw('IFNULL(c.nombre,"sin categoria") AS categoria'), DB::raw('IFNULL(f.categoria_id,"") AS categoria_id'),
                    DB::raw('IF(f.tipo_flujo=1,"Trámite","Proceso de oficio") as tipo_flujo,f.tipo_flujo as tipo_flujo_id')
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
                                ->where('rfd.estado', '=', '1')
                                ->whereRaw('rf.id is not null')
                                ->whereRaw('rfd.area_id IN ('.
                                                'SELECT a.id
                                                FROM area_cargo_persona acp
                                                INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                                INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                WHERE acp.estado=1
                                                AND cp.persona_id='.Auth::user()->id.'
                                             )'
                                            );
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
        }
                
        return $flujo;
    }
}
