<?php

class RutaDetalleMicro extends Base
{
    public $table = "rutas_detalle_micro";
    public static $where = ['id', 'ruta_flujo_id', 'ruta_id','norden', 'estado'];
    public static $selec = ['id', 'ruta_flujo_id', 'ruta_id','norden', 'estado'];
    
        public static function getListar(){
        $rdm=DB::table('rutas_detalle_micro as rdm')
                ->join('rutas_flujo as rf','rf.id','=','rdm.ruta_flujo_id')
                ->join('flujos as f','f.id','=','rf.flujo_id')
                ->select('f.nombre','rdm.id','rdm.estado')
                ->where( 'rdm.ruta_id','=',Input::get('ruta_id'))
                ->where( 'rdm.norden','=',Input::get('norden'))
                ->where( 'rdm.estado','=',1)
                ->get();
        return $rdm;
    }

}
