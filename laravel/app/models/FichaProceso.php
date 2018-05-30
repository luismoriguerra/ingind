<?php

class FichaProceso extends \Eloquent {

    protected $fillable = [];
    public $table = "ficha_proceso";

    public static function getCargar() {
        $result= FichaProceso::select('p1','p2','p3','p4','ficha_proceso.estado','ficha_proceso.id',
                                      DB::raw('IFNULL(r1,"") as r1'),DB::raw('IFNULL(r2,"") as r2'),DB::raw('IFNULL(r3,"") as r3'),DB::raw('IFNULL(r4,"") as r4'),
                                      DB::raw('IFNULL(fpr.id,"") as ficha_proceso_respuesta_id'))
                ->leftjoin('ficha_proceso_respuesta as fpr', function($join){
                        $join->on('fpr.ficha_proceso_id', '=', 'ficha_proceso.id');
                        $join->where('fpr.estado', '=', 1);
                        $join->where('fpr.usuario_created_at', '=', Auth::user()->id);
                })
                ->where('ficha_proceso.estado','=',1)
                ->whereRaw('CURRENT_TIMESTAMP() BETWEEN ficha_proceso.created_at AND ADDDATE(ficha_proceso.created_at,15)')->get();
        return $result;
    }
}
