<?php

class GastosContables extends \Eloquent {

    protected $fillable = [];
    public $table = "contabilidad_gastos";


    public static $where =['id', 'proveedor', 'nro_expede', 'monto_total', 'estado', 'monto_historico', 'total_gc', 'total_gd', 'total_gg'];
    public static $selec =['id', 'proveedor', 'nro_expede', 'monto_total', 'estado', 'monto_historico', 'total_gc', 'total_gd', 'total_gg'];
    
    public static function getCargarCount( $array ) //este metodo se ejecuta cuando ingresas datos en los texbox de busqueda!
    {
        $sSql=" SELECT COUNT(v.id) cant
                FROM contabilidad_gastos v
                INNER JOIN contabilidad_proveedores vv ON v.contabilidad_proveedores_id = vv.id
                WHERE 1=1 ";
        $sSql.= $array['where'];
        $oData = DB::select($sSql);
        return $oData[0]->cant;
    }

    public static function getCargar( $array )
    {
        $sSql=" SELECT v.id, v.contabilidad_proveedores_id, vv.proveedor, v.nro_expede, v.monto_total, v.estado, v.monto_historico,
                    @MGC := (SELECT SUM(cgd1.monto_expede)
                                    FROM contabilidad_gastos_detalle cgd1 
                                        WHERE cgd1.tipo_expede = 'GC' AND cgd1.contabilidad_gastos_id = v.id) AS total_gc,
                    @MGD := (SELECT SUM(cgd2.monto_expede) 
                                        FROM contabilidad_gastos_detalle cgd2 
                                            WHERE cgd2.tipo_expede = 'GD' AND cgd2.contabilidad_gastos_id = v.id) AS total_gd,
                    @MGG := (SELECT SUM(cgd3.monto_expede) 
                                        FROM contabilidad_gastos_detalle cgd3 
                                            WHERE cgd3.tipo_expede = 'GG' AND cgd3.contabilidad_gastos_id = v.id) AS total_gg,
                    ROUND((@MGC - 
                                IF(@MGG IS NULL, 0, @MGG)), 2) AS total_pagar_gc,
                    ROUND((@MGC - 
                                    IF(@MGD IS NULL, 0, @MGD)), 2) AS total_pagar_gd
                FROM contabilidad_gastos v
                INNER JOIN contabilidad_proveedores vv ON v.contabilidad_proveedores_id = vv.id
                WHERE 1=1 ";

        $sSql.= $array['where'].
                $array['order'].
                $array['limit'];
        $oData = DB::select($sSql);
        return $oData;
    }


    public function getDatos(){
        $verbo=DB::table('contabilidad_gastos')
                ->select('id', 'contabilidad_proveedores_id', 'nro_expede', 'monto_total', 'estado', 'monto_historico')
                ->where( 
                    function($query){
                        if ( Input::get('estado') ) {
                            $query->where('estado','=','1');
                        }
                    }
                )
                ->orderBy('nro_expede')
                ->get();
                
        return $verbo;
    }

}
