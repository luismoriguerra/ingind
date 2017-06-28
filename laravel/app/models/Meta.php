<?php

class Meta extends Base {

    public $table = "metas";
    public static $where = ['id', 'nombre', 'area_multiple_id', 'estado'];
    public static $selec = ['id', 'nombre', 'area_multiple_id', 'estado'];

    public static function getCargarCount($array) {
        $sSql = " SELECT  COUNT(m.id) cant
                FROM metas m
                WHERE 1=1 ";
        $sSql .= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar($array) {
        $sSql = " SELECT m.id, m.nombre,m.fecha, m.estado,m.area_multiple_id
                FROM metas m
                WHERE 1=1 ";
        $sSql .= $array['where'] .
                $array['order'] .
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }

    public function getMeta() {
        $meta = DB::table('metas')
                ->select('id', 'nombre', 'estado')
                ->where(
                function($query) {
                    if (Input::get('estado')) {
                        $query->where('estado', '=', '1');  
                    }
                    if(Input::get('cuadro')){
                        $rst = Area::getRol();
                        foreach ($rst as $value) {
                            $array[] = $value->cargo_id;
                        }
                        if (!in_array(12, $array)) {
                            $query->whereRaw('FIND_IN_SET(' . Auth::user()->area_id . ',area_multiple_id)');
                        }
                    }
                }
                )
                ->orderBy('id')
                ->get();

        return $meta;
    }

}
