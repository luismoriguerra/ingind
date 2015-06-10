<?php
class FlujoTipoRespuesta extends Base
{
    public $table = "flujo_tipo_respuesta";
    public static $where = ['id', 'dtiempo', 'flujo_id', 'tipo_respuesta_id',
     'tiempo_id', 'estado'];
    public static $selec = ['id', 'dtiempo', 'flujo_id', 'tipo_respuesta_id',
     'tiempo_id', 'estado'];
    
    /**
     * Flujo relationship
     */
    public function flujo()
    {
        return $this->belongsTo('Flujo');
    }
    public static function getFlujoTipoRsp()
    {
        return DB::table('flujo_tipo_respuesta as ftr')
                    ->join('flujos as f', 'ftr.flujo_id', '=', 'f.id')
                    ->join('tipos_respuesta as tr', 'ftr.tipo_respuesta_id', '=', 'tr.id')
                    ->leftjoin('tiempos as t', 'ftr.tiempo_id', '=', 't.id')
                    ->select(
                        'ftr.id',
                        'ftr.dtiempo',
                        'ftr.estado',
                        'f.nombre as flujo',
                        'ftr.flujo_id',
                        'tr.nombre as tipo_respuesta',
                        'ftr.tipo_respuesta_id',
                        DB::raw('IFNULL(t.nombre,"") as tiempo'),
                        'ftr.tiempo_id'
                    )
                    ->where(
                        function($query){
                            if( Input::get('usuario') ){
                                $query->whereRaw('f.area_id IN ('.
                                                    'SELECT a.id
                                                    FROM area_cargo_persona acp
                                                    INNER JOIN areas a ON a.id=acp.area_id AND a.estado=1
                                                    INNER JOIN cargo_persona cp ON cp.id=acp.cargo_persona_id AND cp.estado=1
                                                    WHERE acp.estado=1
                                                    AND cp.persona_id='.Auth::user()->id.'
                                                 )'
                                                );
                            }
                        }
                    )
                    ->orderBy('f.nombre')
                    ->get();
    }
}
