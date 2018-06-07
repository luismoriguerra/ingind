<?php
class ReporteProceso extends Eloquent
{
    public $table="rutas_flujo";

    public static function getReporteProceso($areas,$fechaIni,$fechaFin)
    {

    	$dateIni = explode("/", $fechaIni);
    	$dateEnd = explode("/", $fechaFin);

		$pivots = "";
		$lefts = "";
    	if($fechaIni == $fechaFin){

    		$filterMonth = " = '$fechaIni'";

    	}else{ 
    		$pv=0;
    		$limit = 100;

    			$m = (int)$dateIni[1];
    			$y = (int)$dateIni[0];


    		while($y < intval($dateEnd[0]) || $m <= intval($dateEnd[1])){


    			$auxMonth = str_pad($m, 2, "0", STR_PAD_LEFT);
	    		$pivots .= ",count(RFD$pv.id) as {$y}_{$m}\r\n";
				$lefts .= "LEFT JOIN rutas_flujo_detalle as RFD$pv ON DATE_FORMAT(RFD$pv.created_at,'%Y-%m') = '$y-$auxMonth' AND RFD$pv.id = RFD.id\r\n";
				
				$pv++;
    			$m++;

    			if($m == 13){
    				$m = 1;
    				$y++;
    			}
				

    		}

    		$filterMonth = "BETWEEN '$fechaIni' AND '$fechaFin'";
    	}



		$x = "
			SELECT  
			RFD.area_id as a,
			A.nombre as nombre
			,count(RFD.id) as Total
			$pivots
			FROM procesos.rutas_flujo as RF 
			INNER JOIN procesos.rutas_flujo_detalle as RFD ON RF.id = RFD.ruta_flujo_id AND RFD.estado = 1
			INNER JOIN areas as A ON RFD.area_id = A.id
			$lefts
			WHERE RFD.area_id IN($areas) AND DATE_FORMAT(RF.created_at,'%Y/%m') $filterMonth
			AND RFD.norden = 1 AND RF.estado = 1
			GROUP BY A.id;
		";

		//echo $x;
		return DB::select($x);
   	}
}

