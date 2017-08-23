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

    /*
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
                    ROUND((IF(v.monto_total IS NULL, @MGG, v.monto_total) - 
                                IF(@MGG IS NULL, 0, @MGG)), 2) AS total_deuda_gg,
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
    */
    public static function getCargar()
    {
        $sSql = '';
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
                    ROUND((IF(v.monto_total IS NULL, @MGG, v.monto_total) - 
                                IF(@MGG IS NULL, 0, @MGG)), 2) AS total_deuda_gg,
                    ROUND((@MGC - 
                                IF(@MGG IS NULL, 0, @MGG)), 2) AS total_pagar_gc,
                    ROUND((@MGC - 
                                IF(@MGD IS NULL, 0, @MGD)), 2) AS total_pagar_gd
                FROM contabilidad_gastos v
                INNER JOIN contabilidad_proveedores vv ON v.contabilidad_proveedores_id = vv.id
                WHERE 1=1 ";

        if( Input::has("id_proveedor") ){
                $id_proveedor=Input::get("id_proveedor");
                if( trim( $id_proveedor )!='' ){
                    $sSql .= " AND v.contabilidad_proveedores_id = '".$id_proveedor."' ";
                }
            }

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


    // MUESTRA DETALLES DE UN EXPEDIENTE SELECCIONADO
    public static function verDetallesExpe() {
        $sSql = '';
        $sSql .= "SELECT cg.id,
                         cgd.contabilidad_gastos_id,
                         cg.nro_expede,
                            CASE WHEN cgd.tipo_expede='GC' THEN cgd.monto_expede
                            ELSE 0
                            END AS gc,
                            CASE WHEN cgd.tipo_expede='GD' THEN cgd.monto_expede
                            ELSE 0
                            END AS gd,
                            CASE WHEN cgd.tipo_expede='GG' THEN cgd.monto_expede
                            ELSE 0
                            END AS gg,
                         cgd.fecha_documento, cgd.documento, cgd.nro_documento, cgd.esp_d, cgd.fecha_doc_b, cgd.doc_b,
                         cgd.nro_doc_b, cgd.persona_doc_b, cgd.observacion, cgd.estado, cg.nro_expede
                    FROM contabilidad_gastos_detalle cgd
                    INNER JOIN contabilidad_gastos cg ON cgd.contabilidad_gastos_id = cg.id
                    WHERE  1 = 1 ";

        if (Input::has('id') && Input::get('id')) {
            $id = Input::get('id');
            $sSql .= " AND cgd.contabilidad_gastos_id = '".$id. "';";
        }

        $oData = DB::select($sSql);
        return $oData;
    }
}
