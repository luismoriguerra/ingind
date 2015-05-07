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
                ->select('f.id','f.nombre','f.estado','a.nombre AS area','f.area_id','f.area_id AS evento')
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
                        elseif ( Input::get('estado') ) {
                            $query->where('f.estado','=','1');
                        }
                    }
                )
                ->get();
                
        return $flujo;
    }
}
