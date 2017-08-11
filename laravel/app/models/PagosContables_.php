<?php

class PagosContables_ extends \Eloquent {

    protected $fillable = [];
    public $table = "contabilidad_gastos_detalles";

    public static function ReporteDetalleGastos() {
        $sSql = '';
        $sSql .= "SELECT cgd.*, cg.nro_expede, cp.id, cp.ruc, cp.proveedor
					FROM contabilidad_gastos_detalle cgd
					INNER JOIN contabilidad_gastos cg ON cgd.contabilidad_gastos_id = cg.id
					INNER JOIN contabilidad_proveedores cp ON cg.contabilidad_proveedores_id = cp.id
					WHERE cgd.estado = 1 ";

        if (Input::has('ruc') && Input::get('ruc')) {
            $ruc = Input::get('ruc');
            $sSql .= " AND cp.ruc = '".$ruc. "'";
        }

        if( Input::has("proveedor") ){
                $proveedor=explode(" ",Input::get("proveedor"));
                $dproveedor=array();

                for ($i=0; $i < count($proveedor) ; $i++) { 
                	if( trim( $proveedor[$i] )!='' ){
	                    array_push($dproveedor," cp.proveedor LIKE '%".$proveedor[$i]."%' ");
	                }
                }
                if( count($dproveedor)>0 ){
                	$sSql.=" AND ".implode($dproveedor, " OR ");
                }
        }

        if( Input::has("observacion") ){
                $observacion=explode(" ",Input::get("observacion"));
                $dobservacion=array();

                for ($i=0; $i < count($observacion) ; $i++) { 
                	if( trim( $observacion[$i] )!='' ){
	                    array_push($dobservacion," cgd.observacion LIKE '%".$observacion[$i]."%' ");
	                }
                }
                if( count($dobservacion)>0 ){
                	$sSql.=" AND ".implode($dobservacion, " AND ");
                }
        }

        $oData = DB::select($sSql);
        return $oData;
    }

    public static function ReporteDetalleGastosTotales() {
        $sSql = '';
        $sSql .= "SELECT cg.nro_expede, cp.ruc, cp.proveedor, 
								IF(cg.monto_total IS NULL, 0, cg.monto_total) AS monto_total,
								@MGC := (SELECT SUM(cgd1.monto_expede)
													FROM contabilidad_gastos_detalle cgd1 
														WHERE cgd1.tipo_expede = 'GC' AND cgd1.contabilidad_gastos_id = cg.id) AS GC,
								@MGD := (SELECT SUM(cgd2.monto_expede) 
													FROM contabilidad_gastos_detalle cgd2 
														WHERE cgd2.tipo_expede = 'GD' AND cgd2.contabilidad_gastos_id = cg.id) AS GD,
								@MGG := (SELECT SUM(cgd3.monto_expede) 
													FROM contabilidad_gastos_detalle cgd3 
														WHERE cgd3.tipo_expede = 'GG' AND cgd3.contabilidad_gastos_id = cg.id) AS GG,
								ROUND((cg.monto_total - @MGC), 2) AS FC,
								ROUND((cg.monto_total - @MGD), 2) AS FD,
								ROUND((cg.monto_total - @MGG), 2) AS FG
					FROM contabilidad_gastos_detalle cgd
					INNER JOIN contabilidad_gastos cg ON cgd.contabilidad_gastos_id = cg.id
					INNER JOIN contabilidad_proveedores cp ON cg.contabilidad_proveedores_id = cp.id
						WHERE cgd.estado = 1 ";

        if (Input::has('ruc') && Input::get('ruc')) {
            $ruc = Input::get('ruc');
            $sSql .= " AND cp.ruc = '".$ruc. "'";
        }

        if( Input::has("proveedor") ){
                $proveedor=explode(" ",Input::get("proveedor"));
                $dproveedor=array();

                for ($i=0; $i < count($proveedor) ; $i++) { 
                	if( trim( $proveedor[$i] )!='' ){
	                    array_push($dproveedor," cp.proveedor LIKE '%".$proveedor[$i]."%' ");
	                }
                }
                if( count($dproveedor)>0 ){
                	$sSql.=" AND ".implode($dproveedor, " OR ");
                }
        }

        if( Input::has("observacion") ){
                $observacion=explode(" ",Input::get("observacion"));
                $dobservacion=array();

                for ($i=0; $i < count($observacion) ; $i++) { 
                	if( trim( $observacion[$i] )!='' ){
	                    array_push($dobservacion," cgd.observacion LIKE '%".$observacion[$i]."%' ");
	                }
                }
                if( count($dobservacion)>0 ){
                	$sSql.=" AND ".implode($dobservacion, " AND ");
                }
        }

        $sSql .= " GROUP BY cg.nro_expede, cp.ruc, cp.proveedor;";
        
        $oData = DB::select($sSql);
        return $oData;
    }
}
