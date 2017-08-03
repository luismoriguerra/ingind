<?php

class ClasificadorTramite extends Base
{
    public $table = "clasificador_tramite";
    public static $where =[
                        'id', 'tipo_tramite_id', 'nombre',
                         'estado'
                          ];
    public static $selec =[
                        'id',  'tipo_tramite_id', 'nombre',
                         'estado'
                          ];

    public static function getCargar($array)
    {
     
        $sSql=" SELECT ct.ruta_flujo_id,ct.id,tt.id tipo_tramite_id, ct.nombre_clasificador_tramite as nombre, ct.estado,tt.nombre_tipo_tramite tipo_tramite
                    FROM clasificador_tramite ct
                    
                    LEFT JOIN tipo_tramite tt ON tt.id=ct.tipo_tramite_id
                    WHERE ct.estado<2";
        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }
    public static function getCargarCount( $array )
    {
        $sSql=" SELECT  COUNT(ct.id) cant
                FROM clasificador_tramite ct
              
                INNER JOIN tipo_tramite tt ON tt.id=ct.tipo_tramite_id
                WHERE ct.estado<2 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }



    public function getClasificadorTramite(){
        $clasificadortramite=DB::table('clasificador_tramite')
                ->select('id','nombre','estado')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                    }
                )
                ->orderBy('nombre')
                ->get();
                
        return $clasificadortramite;
    }
}
