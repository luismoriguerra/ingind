<?php

class GastosHistorialContables extends \Eloquent {

    protected $fillable = [];
    public $table = "contabilidad_gastos_historicos";

    /*
    public static function insertFirt() {
        $sSql = '';
        $sSql .= "SELECT cg.nro_expede,
								(SELECT SUM(cgd1.monto_expede)
									FROM contabilidad_gastos_detalle cgd1
										WHERE cgd1.tipo_expede = 'GC' AND cgd1.contabilidad_gastos_id = cg.id) AS gc,
								(SELECT SUM(cgd2.monto_expede) 
									FROM contabilidad_gastos_detalle cgd2
										WHERE cgd2.tipo_expede = 'GD' AND cgd2.contabilidad_gastos_id = cg.id) AS gd,
								(SELECT SUM(cgd3.monto_expede) 
									FROM contabilidad_gastos_detalle cgd3
										WHERE cgd3.tipo_expede = 'GG' AND cgd3.contabilidad_gastos_id = cg.id) AS gg
					FROM contabilidad_gastos cg
					INNER JOIN contabilidad_gastos_detalle cgd ON cg.id = cgd.contabilidad_gastos_id
						WHERE cgd.estado = 1 ";

        if (Input::has('contabilidad_gastos_id') && Input::get('contabilidad_gastos_id')) {
            $contabilidad_gastos_id = Input::get('contabilidad_gastos_id');
            $sSql .= " AND cgd.contabilidad_gastos_id = '".$contabilidad_gastos_id. "'";
        }
        $sSql .= " GROUP BY cg.nro_expede;";

        $oData = DB::select($sSql);
        return $oData;
    }
    */

    public static function listarDatos() {
        $sSql = '';
        $sSql .= "SELECT cg.nro_expede,
						IF(cg.monto_total IS NULL, 0, cg.monto_total) AS monto_total,
						(SELECT SUM(cgd1.monto_expede)
							FROM contabilidad_gastos_detalle cgd1
								WHERE cgd1.tipo_expede = 'GC' AND cgd1.contabilidad_gastos_id = cg.id) AS gc,
						(SELECT SUM(cgd2.monto_expede) 
							FROM contabilidad_gastos_detalle cgd2
								WHERE cgd2.tipo_expede = 'GD' AND cgd2.contabilidad_gastos_id = cg.id) AS gd,
						(SELECT SUM(cgd3.monto_expede) 
							FROM contabilidad_gastos_detalle cgd3
								WHERE cgd3.tipo_expede = 'GG' AND cgd3.contabilidad_gastos_id = cg.id) AS gg,
							cgh.id, cgh.contabilidad_gastos_id, cgh.anio_pago, cgh.cuenta_contable, cgh.saldo_actual,
							cgh.saldo_presupuesto, cgh.estado, cgh.created_at
					FROM contabilidad_gastos cg
					INNER JOIN contabilidad_gastos_detalle cgd ON cg.id = cgd.contabilidad_gastos_id
					INNER JOIN contabilidad_gastos_historicos cgh ON cg.id = cgh.contabilidad_gastos_id
					WHERE cgd.estado = 1 ";

        if (Input::has('id') && Input::get('id')) {
            $id = Input::get('id');
            $sSql .= " AND cgh.contabilidad_gastos_id = '".$id. "'";
        }
        $sSql .= " GROUP BY cg.nro_expede, cgh.anio_pago;";

        $oData = DB::select($sSql);
        return $oData;
    }



    // MUESTRA SALDOS POR PAGAR
    public static function listarSaldosPagar() {
        $sSql = '';
        $sSql .= "SELECT v.id, v.contabilidad_proveedores_id, vv.proveedor, v.nro_expede,
					@MGC := (SELECT SUM(cgd1.monto_expede)
									FROM contabilidad_gastos_detalle cgd1 
										WHERE cgd1.tipo_expede = 'GC' AND cgd1.contabilidad_gastos_id = v.id) AS total_gc,
					@MGD := (SELECT SUM(cgd2.monto_expede) 
										FROM contabilidad_gastos_detalle cgd2 
											WHERE cgd2.tipo_expede = 'GD' AND cgd2.contabilidad_gastos_id = v.id) AS total_gd,
					@MGG := (SELECT SUM(cgd3.monto_expede) 
										FROM contabilidad_gastos_detalle cgd3 
											WHERE cgd3.tipo_expede = 'GG' AND cgd3.contabilidad_gastos_id = v.id) AS total_gg,
					ROUND((@MGC - @MGG), 2) AS total_pagar
				FROM contabilidad_gastos v
				INNER JOIN contabilidad_proveedores vv ON v.contabilidad_proveedores_id = vv.id ";

        if (Input::has('id') && Input::get('id')) {
            $id = Input::get('id');
            $sSql .= " AND v.contabilidad_proveedores_id = '".$id. "'";
        }
        $sSql .= " AND ((SELECT SUM(cgd1.monto_expede)
									FROM contabilidad_gastos_detalle cgd1 
										WHERE cgd1.tipo_expede = 'GC' AND cgd1.contabilidad_gastos_id = v.id) - 
									(SELECT SUM(cgd3.monto_expede) 
										FROM contabilidad_gastos_detalle cgd3 
											WHERE cgd3.tipo_expede = 'GG' AND cgd3.contabilidad_gastos_id = v.id)) > 0";

        $sSql .= " GROUP BY v.nro_expede;";

        $oData = DB::select($sSql);
        return $oData;
    }

}
