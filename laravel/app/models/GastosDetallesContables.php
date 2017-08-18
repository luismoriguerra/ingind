<?php

class GastosDetallesContables extends \Eloquent {

    protected $fillable = [];
    public $table = "contabilidad_gastos_detalle";

    public static function ReporteDetalleGastos() {
        $sSql = '';
        $sSql .= "SELECT cgd.contabilidad_gastos_id, 
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
                         cgd.nro_doc_b, cgd.persona_doc_b, cgd.observacion, cgd.estado,
                         cg.nro_expede, cp.id, cp.ruc, cp.proveedor
					FROM contabilidad_gastos_detalle cgd
					INNER JOIN contabilidad_gastos cg ON cgd.contabilidad_gastos_id = cg.id
					INNER JOIN contabilidad_proveedores cp ON cg.contabilidad_proveedores_id = cp.id ";

        if (Input::has('saldos_pago') && Input::get('saldos_pago') == 'S') {
            $sSql .= " INNER JOIN (
                            SELECT cgd2.contabilidad_gastos_id, SUM(IF(cgd2.tipo_expede='GC', cgd2.monto_expede, 0)) gc,
                                    SUM(IF(cgd2.tipo_expede='GG',cgd2.monto_expede,0)) gg
                                    FROM contabilidad_gastos_detalle cgd2
                                    GROUP BY cgd2.contabilidad_gastos_id
                                    HAVING gc != gg
                        ) saldos ON saldos.contabilidad_gastos_id=cg.id";  
        }


		$sSql .= "    WHERE cgd.estado = 1 ";

        if (Input::has('ruc') && Input::get('ruc')) {
            $ruc = Input::get('ruc');
            $sSql .= " AND cp.ruc = '".$ruc. "'";
        }

        if (Input::has('nro_expede') && Input::get('nro_expede')) {
            $nro_expede = Input::get('nro_expede');
            $sSql .= " AND cg.nro_expede = '".$nro_expede. "'";
        }

        if( Input::has("proveedor") ){
                $proveedor=explode(" ",Input::get("proveedor"));
                //$proveedor= Input::get("proveedor");
                $dproveedor=array();
                for ($i=0; $i < count($proveedor) ; $i++) { 
                	if( trim( $proveedor[$i] )!='' ){
	                    array_push($dproveedor," cp.proveedor LIKE '%".$proveedor[$i]."%' ");
	                }
                }
                if( count($dproveedor)>0 ){
                	$sSql.=" AND ".implode($dproveedor, " OR ");
                }
                //$sSql.=" AND UPPER(cp.proveedor) LIKE '%".strtoupper($proveedor). "%'";
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

        if (Input::has('fecha_ini') && Input::get('fecha_ini') && Input::has('fecha_fin') && Input::get('fecha_fin')) {
            $fecha_ini=Input::get('fecha_ini');
            $fecha_fin=Input::get('fecha_fin');
            $sSql .= "AND DATE_FORMAT(cgd.fecha_documento,'%Y-%m') BETWEEN '" . $fecha_ini . "' AND '" . $fecha_fin . "' ";
        }

        $sSql .= " ORDER BY cg.nro_expede;";
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
					INNER JOIN contabilidad_proveedores cp ON cg.contabilidad_proveedores_id = cp.id ";

        if (Input::has('saldos_pago') && Input::get('saldos_pago') == 'S') {
            $sSql .= " INNER JOIN (
                            SELECT cgd2.contabilidad_gastos_id, SUM(IF(cgd2.tipo_expede='GC', cgd2.monto_expede, 0)) gc,
                                    SUM(IF(cgd2.tipo_expede='GG',cgd2.monto_expede,0)) gg
                                    FROM contabilidad_gastos_detalle cgd2
                                    GROUP BY cgd2.contabilidad_gastos_id
                                    HAVING gc != gg
                        ) saldos ON saldos.contabilidad_gastos_id=cg.id";  
        }

			$sSql .= " WHERE cgd.estado = 1 ";

        if (Input::has('ruc') && Input::get('ruc')) {
            $ruc = Input::get('ruc');
            $sSql .= " AND cp.ruc = '".$ruc. "'";
        }

        if (Input::has('nro_expede') && Input::get('nro_expede')) {
            $nro_expede = Input::get('nro_expede');
            $sSql .= " AND cg.nro_expede = '".$nro_expede. "'";
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

        if (Input::has('fecha_ini') && Input::get('fecha_ini') && Input::has('fecha_fin') && Input::get('fecha_fin')) {
            $fecha_ini=Input::get('fecha_ini');
            $fecha_fin=Input::get('fecha_fin');
            $sSql .= "AND DATE_FORMAT(cgd.fecha_documento,'%Y-%m') BETWEEN '" . $fecha_ini . "' AND '" . $fecha_fin . "' ";
        }

        $sSql .= " GROUP BY cg.nro_expede, cp.ruc, cp.proveedor;";
        
        $oData = DB::select($sSql);
        return $oData;
    }


    // PROCESO DE REPORTES DE SALDOS POR PAGAR A PROVEEDORES
    public static function ReporteSaldosPagar() {
        $sSql = '';
        $sSql .= " SELECT cg.nro_expede, cp.ruc, cp.proveedor, 
                        @MGC := (SELECT SUM(cgd1.monto_expede)
                                            FROM contabilidad_gastos_detalle cgd1 
                                                WHERE cgd1.tipo_expede = 'GC' AND cgd1.contabilidad_gastos_id = cg.id) AS total_gc,
                        @MGD := (SELECT SUM(cgd2.monto_expede) 
                                            FROM contabilidad_gastos_detalle cgd2 
                                                WHERE cgd2.tipo_expede = 'GD' AND cgd2.contabilidad_gastos_id = cg.id) AS total_gd,
                        @MGG := (SELECT SUM(cgd3.monto_expede) 
                                            FROM contabilidad_gastos_detalle cgd3 
                                                WHERE cgd3.tipo_expede = 'GG' AND cgd3.contabilidad_gastos_id = cg.id) AS total_gg,
                        ROUND((@MGC - 
                                    IF(@MGG IS NULL, 0, @MGG)), 2) AS total_pagar_gc,
                        ROUND((@MGC - 
                                        IF(@MGD IS NULL, 0, @MGD)), 2) AS total_pagar_gd
                    FROM contabilidad_gastos_detalle cgd
                    INNER JOIN contabilidad_gastos cg ON cgd.contabilidad_gastos_id = cg.id
                    INNER JOIN contabilidad_proveedores cp ON cg.contabilidad_proveedores_id = cp.id";

        if (Input::has('ruc') && Input::get('ruc')) {
            $ruc = Input::get('ruc');
            $sSql .= " AND cp.ruc = '".$ruc. "'";
        }

        if (Input::has('fecha')) {
            $fecha = Input::get('fecha');
            list($fechaIni, $fechaFin) = explode(" - ", $fecha);
            $sSql.=' AND cgd.fecha_documento BETWEEN "'.$fechaIni.'" AND "'.$fechaFin.'" ';
        }else{
            $fecha = '';
        }

        $sSql .= " AND (
                            (SELECT SUM(cgd1.monto_expede)
                                FROM contabilidad_gastos_detalle cgd1 
                                    WHERE cgd1.tipo_expede = 'GC' AND cgd1.contabilidad_gastos_id = cg.id ";
                    if($fecha)    
                            $sSql .= " AND cgd1.fecha_documento BETWEEN '" . $fechaIni . "' AND '" . $fechaFin . "' ";
        
                        $sSql .= " ) -
                                IF((@W_MGC := 
                                        (SELECT SUM(cgd3.monto_expede) 
                                            FROM contabilidad_gastos_detalle cgd3 
                                                WHERE cgd3.tipo_expede = 'GG' AND cgd3.contabilidad_gastos_id = cg.id ";
                    if($fecha)    
                                        $sSql .= " AND cgd3.fecha_documento BETWEEN '" . $fechaIni . "' AND '" . $fechaFin . "' ";
                                
                                $sSql .= " )) IS NULL, 
                                            0,
                                        @W_MGC
                                )
                ) > 0 ";

        $sSql .= " GROUP BY cg.nro_expede, cp.ruc, cp.proveedor ";
        $sSql .= " ORDER BY cg.nro_expede;";

        $oData = DB::select($sSql);
        return $oData;
    }
    // --


}
